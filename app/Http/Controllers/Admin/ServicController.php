<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Service;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServicController extends Controller
{

    public function index()
    {
        return view('admin-pages.service.services',[
            'services'  => Service::latest()->paginate(10),
        ]);
    }


    public function create()
    {
        return view('admin-pages.service.create',[
            'menus'   =>    Menu::approved()->where('main_menu','service')->get()
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
                'slug'      =>  [Rule::unique('services','slug'),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The service slug has already has taken.',
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

        $service = new Service();
        $service->title         = $request->title;
        $service->sub_title     = $request->sub_title;
        $service->slug          = $request->slug;
        $service->menu_id       = $request->menu_id;
        $service->submenu_id    = $request->submenu_id;
        $service->description   = $request->description;
        $service->image         = $imgPath;
        $service->status        = $request->status == null ? 0 : $request->status;
        $service->save();

        Toastr::success('Successfully create a new service', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.services');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin-pages.service.create',[
            'service'   =>  $service,
            'menus'     =>  Menu::approved()->where('main_menu','service')->get(),
            'submenus'  =>  $service->menu->submenus,
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
                'slug'      =>  [Rule::unique('services','slug')->ignore($id, "id"),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The service slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->back();
        }
        $service = Service::findOrFail($id);
        if ($request->image){
            if(Storage::disk('public')->exists("$service->image")) {
                Storage::disk('public')->delete("$service->image");
            }
            $imgPath = $this->saveImage($request->image);
            $service->image         = $imgPath;
        }

        $service->title         = $request->title;
        $service->sub_title     = $request->sub_title;
        $service->slug          = $request->slug;
        if($request->menu_id) {
            $service->menu_id   = $request->menu_id;
        }
        $service->submenu_id    = $request->submenu_id;
        $service->description   = $request->description;
        $service->status        = $request->status == null ? 0 : $request->status;
        $service->save();

        Toastr::success('Service updated successful!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.services');
    }


    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        if(Storage::disk('public')->exists("$service->image")) {
            Storage::disk('public')->delete("$service->image");
        }
        $service->delete();
        Toastr::success('Successfully delete service!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.services');
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
