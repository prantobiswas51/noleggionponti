<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Term;
use Illuminate\Http\Request;

use function Pest\Laravel\get;

class DashboardController extends Controller
{
    public function terms(){
        $terms = Term::latest()->first();
        return view('terms_and_conditions', compact('terms'));
    }

    public function policy(){
        $policy = Policy::latest()->first();
        return view('privacy_policy', compact('policy'));
    }
}
