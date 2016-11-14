<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'url',
        'image',
        'position_id',
        'status'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function getPositionListAttribute()
    {
        return array('' => 'Choose Position') +  Position::pluck('name', 'id')->all();
    }
}
