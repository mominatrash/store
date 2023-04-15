<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';
    protected $guarded = [];
    public $timestamps = false;

    protected $appends = ['games_countries','reviews'];


    public function getGamesCountriesAttribute()
    {
        $gc = Games_country::where('game_id', $this->id)->get()->makeHidden(['created_at','updated_at']);
        // $countries = [];
        // foreach ($gc as $item) {
        //     $country = Games_country::where('country_id', $item->country_id)->first()->;
        //     $countries[] = $country;
        // }

        return $gc;
    }


    public function getReviewsAttribute()

    {


    $rev = Review::where('game_id', $this->id)->get(['name','rating','comment']);
    return $rev;

    }


}

