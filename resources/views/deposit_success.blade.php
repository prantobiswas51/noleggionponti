<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-white to-green-100 py-12 px-4">
        <div class="bg-white border-2 border-green-300 rounded-2xl shadow-2xl p-6 sm:p-8 md:p-10 max-w-lg w-full text-center transition-transform hover:-translate-y-1 hover:shadow-green-200">
            <div class="flex justify-center mb-8">
                <div class="bg-green-100 rounded-full p-5 shadow-inner">
                    <svg class="w-14 h-14 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl sm:text-3xl font-extrabold text-green-700 mb-1 tracking-tight">Payment Successful</h2>
            <p class="text-gray-600 mb-8 text-base sm:text-lg">Thank you for your payment. Your transaction has been completed successfully.</p>

            <div class="shadow rounded-xl overflow-x-auto w-full my-6 border border-green-100 bg-green-50/40">
                <table class="min-w-full text-left text-sm sm:text-base">
                    <tbody>
                        <tr class="border-b border-green-200">
                            <td class="px-4 sm:px-6 py-4 font-semibold text-green-700">
                                Payment ID
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-gray-800 text-right break-all">
                                {{ $result->id }}
                            </td>
                        </tr>
                        <tr class="border-b border-green-200">
                            <td class="px-4 sm:px-6 py-4 font-semibold text-green-700">
                                Payer Email
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-gray-800 text-right break-all">
                                {{ $result->payer->payer_info->email }}
                            </td>
                        </tr>
                        <tr class="border-b border-green-200">
                            <td class="px-4 sm:px-6 py-4 font-semibold text-green-700">
                                Payment Status
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                @if ($result->state == 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600 border border-green-300">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600 border border-red-300">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Rejected
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr class="border-b border-green-200">
                            <td class="px-4 sm:px-6 py-4 font-semibold text-green-700">
                                Amount
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-gray-800 text-right">
                                ${{ $result->transactions[0]->amount->total }}
                            </td>
                        </tr>
                        <tr class="border-b border-green-200">
                            <td class="px-4 sm:px-6 py-4 font-semibold text-green-700">
                                Date
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-gray-800 text-right">
                                {{ $result->create_time }}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 sm:px-6 py-4 font-semibold text-green-700">
                                Currency
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-gray-800 text-right">
                                {{ $result->transactions[0]->amount->currency }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <a href="{{ route('dashboard') }}"
                class="inline-block bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white font-bold py-2 px-8 rounded-lg shadow-md mt-6 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2">
                Go to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>