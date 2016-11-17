<?php


namespace App\Http\Controllers;


use App\Character;
use App\Content;
use App\Position;
use Illuminate\Http\Request;

class FrontendController extends Controller
{


    public function index()
    {
        $page = 'index';

        $latestGuides = Content::latest('created_at')->limit(6)->get();
        $hotGuides = Content::whereHas('modules', function($q) {
             $q->where('key_type', 'hot_guide');
        })->limit(6)->get();

        return view('frontend.index', compact('page', 'latestGuides', 'hotGuides'));

    }

    public function character($value)
    {
        $character = Character::whereSlug($value)->get();

        if ($character->count() > 0) {
            $character = $character->first();

            $guides = Content::where('character_id', $character->id)->limit(6)->get();

            return view('frontend.champion', compact('character', 'guides'));
        }
    }

    public function main($value)
    {

        if (preg_match('/([a-z0-9\-]+)\.html/', $value, $matches)) {
            $guide = Content::whereSlug($matches[1])->get();

            if ($guide->count() > 0){
                $guide =  $guide->first();

                return view('frontend.guide', compact('guide'));
            }

        } else {
            //duong
            $position = Position::whereSlug($value)->get();

            if ($position->count() > 0) {
                $position = $position->first();
                $characters = Character::whereHas('contents', function($q) use ($position) {
                    $q->where('position_id', $position->id);
                })->limit(6)->get();
                $guides = Content::where('position_id', $position->id)->limit(6)->get();
                return view('frontend.line', compact('guides', 'position', 'characters', 'guides'));
            }
        }
    }

    public function ajax(Request $request)
    {
        $search = $request->input('q');
        $records = Character::where('title', 'like', '%'.$search.'%')->get();
        $response = [];
        foreach ($records as $record) {
            $response[] = ['id' => $record->id, 'title' => $record->title, 'slug' => $record->slug, 'image' => $record->image];
        }
        return response()->json($response);
    }

    public function ajaxChamp($id)
    {
        $character = Character::find($id);
        if ($character->contents->count() > 0) {
            $guides = Content::where('character_id', $character->id)->limit(6)->get();
            return view('frontend.champion_detail', compact('character', 'guides'))->render();
        } else {
            return;
        }
    }

}