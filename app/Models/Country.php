<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $guarded = [];
    public $timestamps = false;


 

}



        // $packages = Package::join('games_countries', 'packages.game_id', '=', 'games_countries.game_id')
        // ->join('countries', 'games_countries.country_id', '=', 'countries.id')
        // ->where('games_countries.country_id', $this->id)
        // ->select('packages.quantity', 'packages.name')
        // ->get();

        //  return $packages;
