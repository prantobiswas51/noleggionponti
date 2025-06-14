<?php

namespace App\Http\Controllers;

use App\Models\User;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use App\Models\Invoice;
use App\Models\Setting;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;

use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class DepositController extends Controller
{

    private $_api_context;

    public function __construct()
    {
        // sandbox
        $clientId = 'ASHOHgX3ObKUiLPepgJwPCOwJUAKtilCzwLEfuldxH_pDZOOiR-oDNmU4Hfs7iArSF9yCX1RmLnrPPmd';
        $clientSecret = 'EGVhfmGDQjHD0jhNfYlYUFhvyxA53lqzi1unDlX4CEANuiMq_3-3-tu2LiqnlqRqplL5zdTl2lqfy4by';
            
        // Create PayPal API Context
        $this->_api_context = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($clientId, $clientSecret)
        );

        // Set custom config (no env)
        $this->_api_context->setConfig([
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'ERROR',
        ]);
    }

    public function payWithPaypal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($request->amount);
        $amount->setCurrency('EUR');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(URL::route('deposit_status'))->setCancelUrl(URL::route('deposit_status'));

        $payment = new Payment();
        $payment->setIntent('sale')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            if (Config::get('app.debug')) {
                Session::put('error', 'Connection Timeout');
                return Redirect::route('deposit');
            } else {
                Session::put('error', 'Something went wrong! Sorry for inconveninet');
                return Redirect::route('deposit');
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }

        Session::put('error', 'Unknow Error Occurred');
        return Redirect::route('deposit');
    }

    // paypal
    public function getPaypalPaymentStatus(Request $request)
    {
        $paymentId = $request->query('paymentId');
        $PayerID = $request->query('PayerID');
        $token = $request->query('token');

        if (empty($PayerID) || empty($token)) {
            Session::put('error', 'Payment Failed');
            return redirect()->route('deposit');
        }

        try {
            $payment = Payment::get($paymentId, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($PayerID);

            $result = $payment->execute($execution, $this->_api_context);

            if ($result->getState() === 'approved') {
                Session::put('success', 'Payment successful!');

                $total_amount = $result->transactions[0]->amount->total;

                Auth::user()->increment('balance', $total_amount);

                \App\Models\Transaction::create([
                    'user_id' => Auth::id(),
                    'method' => 'Paypal',
                    'payer_email' => $result->payer->payer_info->email,
                    'amount' => $total_amount,
                    'status' => $result->state
                ]);

                // Mail::raw('Your Transaction is Completed', function ($message) {
                //     $message->to(Auth::user()->email)
                //         ->subject('Deposit VirtualCardEU');
                // });

                return view('deposit_success', compact('result'));
            } else {
                Session::put('error', 'Payment not approved.');
                return redirect()->route('deposit');
            }
        } catch (\Exception $e) {
            Session::put('error', 'Error processing payment: ' . $e->getMessage());
            return redirect()->route('deposit');
        }
    }
}