<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ContentsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth.backend');
    }

    private function init($request)
    {
        $path = $request->path();
        $realModel = explode('/', $path)[1];

        if (!$this->checkPermission($realModel)) {
            flash('Not have permission!', 'error');
            return redirect('admin/notice');
        }

        $modelName = '\\App\\' . ucfirst(str_singular($realModel));
        $fields = config('site.content')[$realModel]['fields'];
        $modules = isset(config('site.content')[$realModel]['modules']) ? config('site.content')[$realModel]['modules'] : [];

        return [$realModel, $modelName, $fields, $modules];
    }

    /**
     * Save images
     * @param $file
     * @param null $old
     * @return string
     */
    private function saveImage($file, $old = null)
    {
        $filename = md5(time()) . '.' . $file->getClientOriginalExtension();
        Image::make($file->getRealPath())->save(public_path('files/' . $filename));
        if ($old) {
            @unlink(public_path('files/' . $old));
        }
        return $filename;
    }

    private function checkPermission($content)
    {
        $currentUserPermission = config('site.users')[session()->get('admin_login')];
        $permissionList = config('site.permission')[$currentUserPermission];
        if ($permissionList == 'all' || strpos($permissionList, $content) !== false) {
            return true;
        }
        return false;
    }

    public function index(Request $request)
    {

        list($realModel, $modelName, $fields, $modules) = $this->init($request);

        $searchContent = '';
        $modelContents = $modelName::latest('updated_at');


        if ($request->input('q')) {
            $searchContent = urldecode($request->input('q'));
            $modelContents = $modelContents->where('title', 'LIKE', '%' . $searchContent . '%');
        }
        $modelContents = $modelContents->paginate(config('site.item_per_page'));

        return view('admin.content.index', compact('realModel', 'fields', 'modelContents', 'searchContent', 'modules'));
    }

    public function create(Request $request)
    {
        list($realModel, $modelName, $fields) = $this->init($request);
        return view('admin.content.form', compact('realModel', 'fields', 'modelName'));

    }
    public function store(Request $request)
    {
        $data = $request->all();
        list($realModel, $modelName, $fields, $modules) = $this->init($request);

        $tagIds = [];

        foreach ($data as $key => $value) {
            foreach ($fields as $field) {
                if ($key == $field['value'] || (isset($field['edit_value'])) && $key == $field['edit_value']) {
                    if ($field['type'] == 'image') {
                        if ($request->file($key) && $request->file($key)->isValid()) {
                            $data[$key] = $this->saveImage($request->file($key));
                        } else {
                            unset($data[$key]);
                        }
                    } else if ($field['type'] == 'boolean') {
                        $data[$key] = ($request->input($key) == 'on') ? true : false;
                    } else if ($field['type'] == 'tag') {
                        $tagIds = [];
                        foreach ($request->input('tag_list') as $tag) {
                            $tagIds[] = Tag::firstOrCreate(['title' => $tag])->id;
                        }
                    }
                }
            }
        }

        $newContent = $modelName::create($data);
        if ($tagIds) {
            $newContent->tags()->sync($tagIds);
        }
        flash('Create '.str_singular($realModel).' success!', 'success');
        return $request->input('redirect_back') ? redirect()->to($request->input('redirect_back')) : redirect('admin/'.$realModel);
    }

    public function edit($id, Request $request)
    {
        list($realModel, $modelName, $fields, $modules) = $this->init($request);
        $modelContent = $modelName::find($id);

        return view('admin.content.form', compact('fields', 'modelName', 'modelContent', 'realModel'));
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        list($realModel, $modelName, $fields, $modules) = $this->init($request);
        $modelContent = $modelName::find($id);

        $tagIds = [];

        foreach ($data as $key => $value) {
            foreach ($fields as $field) {
                if ($key == $field['value'] || (isset($field['edit_value'])) && $key == $field['edit_value']) {
                    if ($field['type'] == 'image') {
                        if ($request->file($key) && $request->file($key)->isValid()) {
                            $data[$key] = $this->saveImage($request->file($key));
                        } else {
                            unset($data[$key]);
                        }
                    } else if ($field['type'] == 'boolean') {
                        $data[$key] = ($request->input($key) == 'on') ? true : false;
                    } else if ($field['type'] == 'tag') {
                        $tagIds = [];
                        foreach ($request->input('tag_list') as $tag) {
                            $tagIds[] = Tag::firstOrCreate(['title' => $tag])->id;
                        }
                    }
                }
            }
        }

        $modelContent->update($data);
        if ($tagIds) {
            $modelContent->tags()->sync($tagIds);
        }
        flash('Update '.str_singular($realModel).' success!', 'success');
        return $request->input('redirect_back') ? redirect()->to($request->input('redirect_back')) : redirect('admin/'.$realModel);
    }

    public function destroy($id, Request $request)
    {
        list($realModel, $modelName, $fields, $modules) = $this->init($request);
        $modelContent = $modelName::find($id);

        if (file_exists(public_path('files/' . $modelContent->image))) {
            @unlink(public_path('files/' . $modelContent->image));
        }
        $modelContent->delete();
        flash('Success deleted '.str_singular($realModel).'!');
        return $request->input('redirect_back') ? redirect()->to($request->input('redirect_back')) : redirect('admin/'.$realModel);
    }


}
