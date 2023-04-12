<?php

namespace App\Http\Controllers;

use App\Models\Games_country;
use Illuminate\Http\Request;

class GamesCountryController extends Controller
{
    public function gamesCountries(Request $request){

        $gc = Games_country::where('game_id', $request->game_id)->get();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'data' => $gc
        ]);
    }
}
