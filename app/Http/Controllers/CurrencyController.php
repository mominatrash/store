<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function currency(){
       $c = Currency::get();


       return response()->json([
        'message' => 'data fetched successfully',
        'code' => 200,
        'game' => $c
    ]);

    }
}
