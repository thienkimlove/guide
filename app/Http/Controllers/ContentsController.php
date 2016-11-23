<?php

namespace App\Http\Controllers;

use App\Character;
use App\Content;
use Illuminate\Http\Request;
use Validator;

class ContentsController extends AdminController
{

    public $model = 'contents';

    public $validator = [
        'title' => 'required',
        'character_id' => 'required',
        'position_id' => 'required',
    ];

    protected function syncContent($relation, $ids, $extra_data, $extra_field)
    {
        $syncArrays = [];

        foreach ($ids as $k => $id) {
            if ($id && isset($extra_data[$k]) && $extra_data[$k]) {
                $syncArrays[$id] = [$extra_field => $extra_data[$k]];
            }
        }
        if ($syncArrays) {
            $relation->sync($syncArrays);
        }
    }

    protected function syncContentCharacter($relation, $ids, $extra_data1, $extra_field1, $extra_data2, $extra_field2)
    {
        $syncArrays = [];

        foreach ($ids as $k => $id) {
            if ($id && isset($extra_data1[$k]) && $extra_data1[$k] && isset($extra_data2[$k]) && $extra_data2[$k]) {
                $syncArrays[$id] = [$extra_field1 => $extra_data1[$k], $extra_field2 => $extra_data2[$k]];
            }
        }

        if ($syncArrays) {
            $relation->sync($syncArrays);
        }
    }

    protected function syncSkill($relation, $data)
    {
        $syncSkill = [];

        if (isset($data['skill'])) {
            foreach ($data['skill'] as $skill_id => $skill_value) {
                $syncSkill[$skill_id] = ['step' => implode(',', array_keys($skill_value)).','];
            }
        }

        $relation->sync($syncSkill);
    }

    public function index()
    {
        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $contents = $modelClass::paginate(10);

        $modules = config('site.content')['contents']['modules'];

        return view('admin.'.$this->model.'.index', compact('contents', 'modules'))->with('model', $this->model);
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

        if ($request->file('table_support_1') && $request->file('table_support_1')->isValid()) {
            $data['table_support_1'] = $this->saveImage($request->file('table_support_1'));
        } else {
            unset($data['table_support_1']);
        }

        $modelClass = '\\App\\' . ucfirst(str_singular($this->model));
        $content = $modelClass::create($data);

        //work with supplements.
        $this->syncContent($content->supplements(), $data['supplement_id'], $data['supplement_number'], 'number');
        $this->syncContent($content->equipments(), $data['equipment_id'], $data['equipment_type'], 'type');
        $this->syncContent($content->supports(), $data['support_id'], $data['support_type'], 'type');
        $this->syncContentCharacter($content->characters(), $data['character_select_id'], $data['character_select_manh_hon'], 'manh_hon', $data['character_select_desc'], 'desc');
        $this->syncSkill($content->skills(), $data);

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

        if ($request->file('table_support_1') && $request->file('table_support_1')->isValid()) {
            $data['table_support_1'] = $this->saveImage($request->file('table_support_1'));
        } else {
            unset($data['table_support_1']);
        }

        $content->update($data);


        //work with supplements.
        $this->syncContent($content->supplements(), $data['supplement_id'], $data['supplement_number'], 'number');
        $this->syncContent($content->equipments(), $data['equipment_id'], $data['equipment_type'], 'type');
        $this->syncContent($content->supports(), $data['support_id'], $data['support_type'], 'type');
        $this->syncContentCharacter($content->characters(), $data['character_select_id'], $data['character_select_manh_hon'], 'manh_hon', $data['character_select_desc'], 'desc');
        $this->syncSkill($content->skills(), $data);

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

    public function ajax(Request $request)
    {
        $data = $request->all();
        $content = null;
        if (isset($data['content_id']) && $data['content_id']) {
            $content = Content::find(intval($data['content_id']));
        }
        $character = Character::find(intval($data['character_id']));

        return view('admin.character_skill', compact('content', 'character'))->render();
    }
}