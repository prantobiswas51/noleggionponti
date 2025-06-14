<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Esp32Controller extends Controller
{
    public function esp32_1(){
        return view('esp32_123');
    }

    public function esp32_2(){
        return view('esp32_223');
    }

    public function hasEnough(Request $request, $amount)
    {
        $user = $request->user();

        return response()->json([
            'has_enough' => $user->balance >= $amount,
        ]);
    }

}
