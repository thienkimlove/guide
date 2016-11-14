<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
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
        //general

        'title',
        'seo_title',
        'slug',
        'desc',
        'keywords',
        'content',
        'image',
        'status',
        'views',

        //special
        'city',
        'area'
    ];

    public function getCityDisplayAttribute()
    {
        return config('delivery')['city'][$this->city];
    }

    public function getCityListAttribute()
    {
        return config('delivery')['city'];
    }

    public function getAreaDisplayAttribute()
    {
        return config('delivery')['area'][$this->area];
    }

    public function getAreaListAttribute()
    {
        return config('delivery')['area'];
    }
}
