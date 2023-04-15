<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Game;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function generate(Request $request){
        $x = $request->code;
        $codes = []; // Create an empty array to store the generated codes
        for ($i = 0; $i < $x; $i++) {
            $gens = Str::random(5) . '-' . Str::random(5) . '-' . Str::random(5);
            $gen = new Code();
            $gen->game_id = $request->game_id;
            $gen->package_id = $request->package_id;
            $gen->code = $gens;
            $gen->save();
            $codes[] = $gen; // Add the generated code to the array
        }

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => $x . ' codes have been generated',
            'data' => $codes // Return the array of generated codes
        ]);
    }



}
