<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Subject;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function index()
    {
        return view('admin-pages.subject.subjects',[
            'subject' => Subject::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin-pages.subject.create',[
            'menus'   =>    Menu::approved()->where('main_menu','subject')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:90'],
                'sub_title' =>  ['required', 'string'],
                'menu_id'   =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('subjects','slug'),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The Subject slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->back();
        }
        $imgPath = null;
        if ($request->image){
            $imgPath = $this->saveImage($request->image);
        }

        $subject = new Subject();
        $subject->title         = $request->title;
        $subject->sub_title     = $request->sub_title;
        $subject->slug          = $request->slug;
        $subject->menu_id       = $request->menu_id;
//        $subject->submenu_id    = $request->submenu_id;
        $subject->description   = $request->description;
        $subject->total_class   = $request->total_class;
        $subject->total_hour    = $request->total_hour;
        $subject->fee           = $request->fee;
        $subject->image         = $imgPath;
        $subject->status        = $request->status == null ? 0 : $request->status;
        $subject->save();

        Toastr::success('Successfully create a new Subject', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.subjects');
    }


    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin-pages.subject.create',[
            'subject'   =>  $subject,
            'menus'     =>  Menu::approved()->where('main_menu','subject')->get(),
//            'submenus'  =>  $subject->menu->submenus,
        ]);

    }


    public function update(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:90'],
                'sub_title' =>  ['required', 'string'],
                'menu_id'   =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('subjects','slug')->ignore($id, "id"),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The subject slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->back();
        }
        $subject = Subject::findOrFail($id);
        if ($request->image){
            if(Storage::disk('public')->exists("$subject->image")) {
                Storage::disk('public')->delete("$subject->image");
            }
            $imgPath = $this->saveImage($request->image);
            $subject->image         = $imgPath;
        }

        $subject->title         = $request->title;
        $subject->sub_title     = $request->sub_title;
        $subject->slug          = $request->slug;
        if($request->menu_id) {
            $subject->menu_id   = $request->menu_id;
        }
//        $subject->submenu_id    = $request->submenu_id;
        $subject->description   = $request->description;
        $subject->total_class   = $request->total_class;
        $subject->total_hour    = $request->total_hour;
        $subject->fee           = $request->fee;
        $subject->status        = $request->status == null ? 0 : $request->status;
        $subject->save();

        Toastr::success('Subject updated successful!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.subjects');
    }


    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        if(Storage::disk('public')->exists("$subject->image")) {
            Storage::disk('public')->delete("$subject->image");
        }
        $subject->delete();
        Toastr::success('Successfully delete subject!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.subjects');
    }

    protected function saveImage($image){
        $imageExtension = strtolower($image->getClientOriginalExtension());
        $imageName  = time().'.'.$imageExtension;

        $imageDirectory  = 'images/';
        $imageUrl   =   $imageDirectory.$imageName;

        if (!Storage::disk('public')->exists($imageDirectory)){
            Storage::disk('public')->makeDirectory($imageDirectory);
        }

        Storage::disk('public')->putFileAs($imageDirectory,$image,$imageName);
        return $imageUrl;
    }


}
