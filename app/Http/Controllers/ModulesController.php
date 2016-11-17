<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class ModulesController extends AdminController
{

    public $model = 'modules';

    public $validator = [
        'key_name' => 'required',
        'key_type' => 'required',
        'key_content' => 'required',
        'key_value' => 'required',
    ];

    public function index()
    {
        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $contents = $modelClass::paginate(10);

        return response()->json($contents);
    }

    public function create()
    {
        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $content = new $modelClass;
        return response()->json($content);
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
        return $request->input('redirect_back') ? redirect()->to($request->input('redirect_back')) : redirect('admin/'.$this->model);

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
        return $request->input('redirect_back') ? redirect()->to($request->input('redirect_back')) : redirect('admin/'.$this->model);
    }

    public function destroy($id, Request $request)
    {
        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $content = $modelClass::find($id);
        $content->delete();
        flash()->success('Success delete '.$this->model.'!');
        return $request->input('redirect_back') ? redirect()->to($request->input('redirect_back')) : redirect('admin/'.$this->model);
    }
}