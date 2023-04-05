<?php

namespace App\Http\Controllers;

use App\Models\Welcome;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome(){

        $welcome = Welcome::get();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'data' => $welcome
        ]);
    }
}
