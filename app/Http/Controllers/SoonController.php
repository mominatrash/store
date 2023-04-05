<?php

namespace App\Http\Controllers;

use App\Models\Soon;
use Illuminate\Http\Request;

class SoonController extends Controller
{
    public function soon(){

        $soon = Soon::get();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'data' => $soon
        ]);
    }
}
