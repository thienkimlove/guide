<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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

        'content_tab1',
        'content_tab2',
        'content_tab3',
        'congdung',
        'xuatxu',
        'giayphep',
        'quycach',
        'tinhtrang',
        'giacu',
        'giamoi',

    ];
}
