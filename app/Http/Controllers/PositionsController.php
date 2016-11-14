<?php

namespace App\Http\Controllers;


use App\Position;
use Illuminate\Http\Request;
use Validator;

class PositionsController extends AdminController
{
    public function index()
    {
        $positions = Position::paginate(10);

        return view('admin.position.index', compact('positions'));
    }

    public function create()
    {
        return view('admin.position.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/positions/create')
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();

        Position::create($data);
        flash()->success('Success create position!');
        return redirect('admin/positions');

    }

    public function edit($id)
    {
        $position = Position::find($id);
        return view('admin.position.form', compact('position'));
    }

    public function update($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/positions/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }
        $position = Position::find($id);
        $data = $request->all();
        $position->update($data);

        flash()->success('Success update position!');
        return redirect('admin/positions');
    }

    public function destroy($id)
    {
        Position::find($id)->delete();
        flash()->success('Success delete position!');
        return redirect('admin/positions');
    }
}