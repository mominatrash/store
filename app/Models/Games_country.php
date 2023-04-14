<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games_country extends Model
{
    use HasFactory;
    protected $table = 'games_countries';
    protected $guarded = [];
    public $timestamps = false;

    protected $appends = ['packages'];

    public function getPackagesAttribute()
    {
        $packages = Package::where('game_id', $this->game_id)
            ->where('country_id', $this->country_id)
            ->get(['quantity','name']);

        return $packages;
    }
}


