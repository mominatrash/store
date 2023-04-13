<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Game;
use App\Models\Games_country;
use App\Models\Package;
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
        $rev = Review::where('game_id', $request->id)->get(['name','rating','comment']);
        $gc = Games_country::where('game_id', $request->id)->get();

        $countries = [];
        foreach ($gc as $item) {
            $country = Country::where('id', $item->country_id)->first(['name','currency']);
            $countries[] = $country;
        }

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'game' => $game,
            'rating' => $rev,
            'country' => $countries
        ]);
    }

    public function packages(Request $request){

        $package = Package::where('game_id',$request->game_id)->where('country_id', $request->country_id)->first(['quantity','name']);
        $game = Game::where('id', $request->game_id)->first('name');
        $country = Country::where('id', $request->country_id)->first('name');

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'Quantity / Type' => $package,
            'game' => $game,
            'country' =>$country
        ]);
    }

    public function search(Request $request){
        $search = Game::where('name', 'like', '%'. $request->name.'%')->get();
        if($search->count() > 0){
            return response()->json([
                'message' => 'Data fetched successfully',
                'code' => 200,
                'data' => $search
            ]);
        } else {
            return response()->json([
                'message' => 'No data found',
                'code' => 404
            ]);
        }
    }





}
