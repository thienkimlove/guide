<?php
/**
 * Created by PhpStorm.
 * User: quandm
 * Date: 11/7/2016
 * Time: 3:30 PM
 */

namespace App\Http\Controllers;


use App\Category;
use App\Delivery;
use App\Post;
use App\Product;
use App\Question;
use App\Tag;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{

    protected function generateMeta($case = null, $meta = [], $mainContent = null)
    {
        $defaultLogo = url(env('LOGO_URL'));
        switch ($case) {
            default :
                return [
                    'meta_title' => env('META_INDEX_TITLE'),
                    'meta_desc' => env('META_INDEX_DESC'),
                    'meta_keywords' => env('META_INDEX_KEYWORD'),
                    'meta_url' => url('/'),
                    'meta_image' => $defaultLogo
                ];
                break;

            case 'lien-he' :
                return [
                    'meta_title' => env('META_CONTACT_TITLE'),
                    'meta_desc' => env('META_CONTACT_DESC'),
                    'meta_keywords' => env('META_CONTACT_KEYWORD'),
                    'meta_url' => url('lien-he'),
                    'meta_image' => $defaultLogo
                ];
                break;
            case 'video' :

                return [
                    'meta_title' => !empty($meta['title']) ? $meta['title'] : env('META_VIDEO_TITLE'),
                    'meta_desc' => empty($meta['desc']) ? $meta['desc'] : env('META_VIDEO_DESC'),
                    'meta_keywords' => empty($meta['keywords']) ? $meta['keywords'] : env('META_VIDEO_KEYWORD'),
                    'meta_url' => ($mainContent) ? url('video/' . $mainContent->slug) : url('video'),
                    'meta_image' => ($mainContent)?  url('img/cache/120x120/'.$mainContent->image) : $defaultLogo
                ];

                break;
            case 'phan-phoi' :
                return [
                    'meta_title' => !empty($meta['title']) ? $meta['title'] : env('META_DELIVERY_TITLE'),
                    'meta_desc' => empty($meta['desc']) ? $meta['desc'] : env('META_DELIVERY_DESC'),
                    'meta_keywords' => empty($meta['keywords']) ? $meta['keywords'] : env('META_DELIVERY_KEYWORD'),
                    'meta_url' => ($mainContent) ? url('phan-phoi/' . $mainContent->id) : url('phan-phoi'),
                    'meta_image' => $defaultLogo
                ];

                break;

            case 'product' :

                return [
                    'meta_title' => !empty($meta['title']) ? $meta['title'] : env('META_PRODUCT_TITLE'),
                    'meta_desc' => empty($meta['desc']) ? $meta['desc'] : env('META_PRODUCT_DESC'),
                    'meta_keywords' => empty($meta['keywords']) ? $meta['keywords'] : env('META_PRODUCT_KEYWORD'),
                    'meta_url' => ($mainContent) ? url('product/' . $mainContent->slug) : url('product'),
                    'meta_image' => ($mainContent)?  url('img/cache/120x120/'.$mainContent->image) : $defaultLogo
                ];

            case 'tag' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => $meta['keywords'],
                    'meta_url' => url('tag/' . $mainContent),
                    'meta_image' => $defaultLogo
                ];
                break;

            case 'hoi-dap' :
                return [
                    'meta_title' => !empty($meta['title']) ? $meta['title'] : env('META_QUESTION_TITLE'),
                    'meta_desc' => empty($meta['desc']) ? $meta['desc'] : env('META_QUESTION_DESC'),
                    'meta_keywords' => empty($meta['keywords']) ? $meta['keywords'] : env('META_QUESTION_KEYWORD'),
                    'meta_url' => ($mainContent) ? url('hoi-dap/' . $mainContent->slug) : url('hoi-dap'),
                    'meta_image' => ($mainContent)?  url('img/cache/120x120/'.$mainContent->image) : $defaultLogo
                ];
                break;
            case 'post' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => $meta['keywords'],
                    'meta_url' => url($mainContent->slug . '.html'),
                    'meta_image' => url('img/cache/120x120/'.$mainContent->image)
                ];
                break;
            case 'category' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' =>  $meta['keywords'] ,
                    'meta_url' => url($mainContent->slug),
                    'meta_image' => $defaultLogo
                ];
                break;
        }

    }

    public function index()
    {
        $page = 'index';

        return view('frontend.index', compact(
            'page'
        ))->with($this->generateMeta());
    }

    public function contact()
    {
        $page = 'lien-he';
        return view('frontend.contact', compact('page'))->with($this->generateMeta('lien-he'));
    }

    public function video($value = null)
    {
        $page = 'video';
        $mainVideo = null;
        $meta_title = $meta_desc = $meta_keywords = null;
        $videos = Video::paginate(6);

        $latestVideos = Video::latest('updated_at')->limit(5)->get();

        if ($videos->count() > 0) {
            $mainVideo = $videos->first();
        }

        if ($value) {
            $mainVideo = Video::where('slug', $value)->first();
            $meta_title = ($mainVideo->seo_title) ? $mainVideo->seo_title : $mainVideo->title;
            $meta_desc = $mainVideo->desc;
            $meta_keywords = $mainVideo->keywords;
            $mainVideo->update(['views' => (int)$mainVideo->views + 1]);
        }


        return view('frontend.video', compact('videos', 'mainVideo', 'latestVideos', 'page'))->with($this->generateMeta('video', [
            'title' => $meta_title,
            'desc' => $meta_desc,
            'keywords' => $meta_keywords,
        ], $mainVideo));

    }

    public function delivery($value = null)
    {
        $page = 'phan-phoi';
        $meta_title = $meta_desc = $meta_keywords = null;
        if ($value) {
            $delivery = Delivery::find($value);
            $meta_title = $delivery->seo_title;
            $meta_desc = $delivery->desc;
            $meta_keywords = $delivery->keywords;

            return view('frontend.detail_delivery', compact('delivery', 'page'))->with($this->generateMeta('phan-phoi', [
                'title' => $meta_title,
                'desc' => $meta_desc,
                'keywords' => $meta_keywords,
            ], $delivery));
        } else {
            $totalDeliveries = [];
            foreach (config('delivery')['area'] as $key => $area) {
                $totalDeliveries[$area] = Delivery::where('area', $key)->get();
            }

            return view('frontend.new_phanphoi', compact('totalDeliveries', 'page'))->with($this->generateMeta('phan-phoi', [
                'title' => $meta_title,
                'desc' => $meta_desc,
                'keywords' => $meta_keywords,
            ]));
        }
    }



    public function saveQuestion(Request $request)
    {
        $data = $request->all();

        if (isset($data['question'])) {

            Mail::send('mails.question', ['data' => $data], function ($m)  {
                $m->from(env('MAIL_USERNAME'), 'Tue Linh')
                    ->to('contact@tuelinh.com')
                    ->subject('Đặt câu hỏi với chuyên gia!');
            });

        }

        return redirect(url('/'));
    }

    public function tag($value)
    {
        $page = 'tag';

        $tag = Tag::where('slug', $value)->get();

        if ($tag->count() > 0) {

            $tag = $tag->first();

            $meta_title = ($tag->seo_title) ? $tag->seo_title : $tag->name;
            $meta_desc = $tag->desc;
            $meta_keywords = $tag->keywords;

            $posts = Post::where('status', true)
                ->whereHas('tags', function ($q) use ($tag) {
                    $q->where('id', $tag->id);
                })
                ->orderBy('updated_at', 'desc')
                ->paginate(10);

            return view('frontend.tag', compact('posts', 'tag', 'page'))->with
            ($this->generateMeta([
                'title' => $meta_title,
                'desc' => $meta_desc,
                'keywords' => $meta_keywords,
            ], $value));
        }
    }

    public function search(Request $request)
    {
        if ($request->input('q')) {
            $keyword = $request->input('q');
            $posts = Post::publish()->where('title', 'LIKE', '%' . $keyword . '%')->paginate(10);

            return view('frontend.search', compact('posts', 'keyword'))->with($this->generateMeta('tag', [
                'title' => 'Tìm kiếm cho từ khóa ' . $keyword,
                'desc' => 'Tìm kiếm cho từ khóa ' . $keyword,
                'keywords' => $keyword,
            ], $keyword));
        }
    }

    public function product($value = null)
    {
        $page = 'product';
        $meta_title = $meta_desc = $meta_keywords = null;
        if ($value) {
            $product = Product::where('slug', $value)->first();
            $meta_title = ($product->seo_title) ? $product->seo_title : $product->title;
            $meta_desc = $product->desc;
            $meta_keywords = $product->keywords;
            return view('frontend.product_detail', compact(
                'product',
                'page'
            ))->with($this->generateMeta('product', [
                'title' => $meta_title,
                'desc' => $meta_desc,
                'keywords' => $meta_keywords,
            ], $product));
        } else {

            $products = Product::paginate(9);

            return view('frontend.product', compact('products', 'page'))->with($this->generateMeta('product', [
                'title' => $meta_title,
                'desc' => $meta_desc,
                'keywords' => $meta_keywords,
            ]));
        }

    }

    public function question($value = null)
    {
        $page = 'hoi-dap';
        $mainQuestion = null;
        $meta_title = $meta_desc = $meta_keywords = null;
        if ($value) {
            $mainQuestion = Question::where('slug', $value)->first();
            $meta_title = ($mainQuestion->seo_title) ? $mainQuestion->seo_title : $mainQuestion->title;
            $meta_desc = $mainQuestion->desc;
            $meta_keywords = $mainQuestion->keywords;
        }
        $questions = Question::where('status', true)->paginate(10);
        return view('frontend.question', compact('questions', 'mainQuestion', 'page'))->with($this->generateMeta('hoi-dap', [
            'title' => $meta_title,
            'desc' => $meta_desc,
            'keywords' => $meta_keywords,
        ], $mainQuestion));
    }

    public function main($value)
    {

        if (preg_match('/([a-z0-9\-]+)\.html/', $value, $matches)) {

            $post = Post::where('slug', $matches[1])->first();
            $post->update(['views' => (int) $post->views + 1]);

            $latestNews = Post::where('status', true)
                ->where('category_id', $post->category_id)
                ->where('id', '!=', $post->id)
                ->latest('updated_at')
                ->limit(6)
                ->get();

            $page = $post->category->slug;

            return view('frontend.post', compact('post', 'latestNews', 'page'))->with($this->generateMeta('post', [
                'title' => ($post->seo_title) ? $post->seo_title : $post->title,
                'desc' => $post->desc,
                'keyword' => ($post->tagList) ? implode(',', $post->tagList) : null,
            ], $post));
        } else {
            $category = Category::where('slug', $value)->first();

            if ($category->subCategories->count() == 0) {
                //child categories
                $posts = Post::where('status', true)
                    ->where('category_id', $category->id)
                    ->latest('updated_at')
                    ->paginate(10);

            } else {
                //parent categories
                $posts = Post::where('status', true)
                    ->whereIn('category_id', $category->subCategories->lists('id')->all())
                    ->latest('updated_at')
                    ->paginate(10);

            }

            $page = $category->slug;

            return view('frontend.category', compact(
                'category', 'posts', 'page'
            ))->with($this->generateMeta('category', [
                'title' => ($category->seo_name) ?  $category->seo_name : $category->name,
                'desc' =>  ($category->desc)? $category->desc : null,
                'keyword' => ($category->keywords)? $category->keywords : null,
            ], $category));
        }
    }


}