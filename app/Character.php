<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable = [
        'title',
        'slug',
        'image',
        'ti_le_thang',
        'ti_le_thua',
        'ti_le_cam',
        'ti_le_chon'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

}
