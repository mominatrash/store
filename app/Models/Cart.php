<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;


    protected $appends = ['games'];


    public function getGamesAttribute()
    {
        $gc = Game1::where('id', $this->game_id)->get(['name'])->makeHidden(['created_at','updated_at']);

        return $gc;
    }
}
