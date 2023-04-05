<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soon extends Model
{
    use HasFactory;
    protected $table = 'soon';
    protected $guarded = [];
    public $timestamps = false;
}
