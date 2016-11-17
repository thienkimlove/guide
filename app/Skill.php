<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'image',
        'character_id',
        'desc',
        'type',
        'change_type',
        'url'
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
