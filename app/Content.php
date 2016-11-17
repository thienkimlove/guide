<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
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
        'character_id',
        'position_id',
        'table_support_1',
        'table_support_2',
        'table_support_3',
        'uu_diem',
        'nhuoc_diem',

        'giai_doan_dau_tran',
        'giai_doan_giua_tran',
        'giai_doan_cuoi_tran',

        'image',
        'desc'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function supplements()
    {
        return $this->belongsToMany(Supplement::class)->withPivot('number');
    }

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class)->withPivot('type');
    }

    public function supports()
    {
        return $this->belongsToMany(Support::class)->withPivot('type');
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot(['manh_hon', 'desc']);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('step');
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'key_value', 'id')->where('key_content', 'contents');
    }

}
