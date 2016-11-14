<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
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
        'category_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * post belong to one category.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * get the tags that associated with given post
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * get the list tags of current post.
     * @return mixed
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('title')->all();
    }

    public function getCategoryListAttribute()
    {
        $categories = Category::all();
        $categoryIds = [];
        foreach ($categories as $cate) {
            if ($cate->subCategories->count() == 0) {
                $categoryIds[] = $cate->id;
            }
        }
        return array(0 => 'Choose category') +  Category::whereIn('id', $categoryIds)->pluck('title', 'id')->all();
    }

    public function getShowOnIndexAttribute()
    {
        $modules = Module::where('key_type', 'show_on_index')
            ->where('key_content', 'posts')
            ->where('key_value', $this->id
            )->get();

        return ($modules->count() > 0)? $modules->first() : null;
    }

    public function getRelatedPostsAttribute()
    {
        $limit = 5;

        $post_tag = $this->tags->pluck('id')->all();

        $relatedPosts = Post::where('status', true)
            ->whereHas('tags', function($q) use ($post_tag){
                $q->whereIn('id', $post_tag);
            })
            ->where('id', '!=', $this->id)
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get();

        $additionPosts = null;

        if ($relatedPosts->count() < $limit) {
            $categoryLimit = $limit - $relatedPosts->count();
            $additionPosts = Post::where('status', true)
                ->where('category_id', $this->category_id)
                ->where('id', '!=', $this->id)
                ->orderBy('updated_at', 'desc')
                ->limit($categoryLimit)
                ->get();
        }
        if ($additionPosts) {
            foreach ($additionPosts as $post) {
                if (!in_array($post->id, $relatedPosts->pluck('id')->all())) {
                    $relatedPosts->push($post);
                }
            }
        }

        return $relatedPosts;
    }

}
