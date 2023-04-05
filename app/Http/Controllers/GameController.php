<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function games(){

        $games = Game::get();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'data' => $games
        ]);
    }


    public function game_id(Request $request){

        $game = Game::where('id', $request->id)->first();
        $rev = Review::where('game_id', $request->id)->get();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'data' => $game, $rev
        ]);

    }
}
