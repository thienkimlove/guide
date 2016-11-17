<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    protected $fillable = [
        'name',
        'image',
        'desc'
    ];
}
