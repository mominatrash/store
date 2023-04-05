<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function banner(){

        $banner = Banner::get();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'data' => $banner
        ]);
    }
}
