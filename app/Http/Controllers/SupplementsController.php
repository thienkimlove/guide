<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;
use Validator;

class SupplementsController extends AdminController
{

    public $model = 'supplements';

    public $validator = [
        'name' => 'required'
    ];

    public function index()
    {
        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $contents = $modelClass::paginate(10);

        return view('admin.'.$this->model.'.index', compact('contents'))->with('model', $this->model);
    }

    public function create()
    {
        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $content = new $modelClass;
        return view('admin.'.$this->model.'.form', compact('content'))->with('model', $this->model);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validator);

        if ($validator->fails()) {
            return redirect('admin/'.$this->model.'/create')
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();

        if ($request->file('image') && $request->file('image')->isValid()) {
            $data['image'] = $this->saveImage($request->file('image'));
        } else {
            unset($data['image']);
        }

        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $modelClass::create($data);
        flash()->success('Success create '.$this->model.'!');
        return redirect('admin/'.$this->model);

    }

    public function edit($id)
    {
        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $content = $modelClass::find($id);
        return view('admin.'.$this->model.'.form', compact('content'))->with('model', $this->model);
    }

    public function update($id, Request $request)
    {

        $validator = Validator::make($request->all(), $this->validator);

        if ($validator->fails()) {
            return redirect('admin/'.$this->model.'/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }
        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $content = $modelClass::find($id);
        $data = $request->all();
        if ($request->file('image') && $request->file('image')->isValid()) {
            $data['image'] = $this->saveImage($request->file('image'), $content->image);
        } else {
            unset($data['image']);
        }
        $content->update($data);

        flash()->success('Success update '.$this->model.'!');
        return redirect('admin/'.$this->model);
    }

    public function destroy($id)
    {
        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $content = $modelClass::find($id);
        $content->delete();
        flash()->success('Success delete '.$this->model.'!');
        return redirect('admin/'.$this->model);
    }
}