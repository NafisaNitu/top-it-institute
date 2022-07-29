<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AboutWidget;
use App\Models\Slider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AboutController extends Controller
{


    public function aboutIndex()
    {
        $about = About::first();
        if ($about){
            return view('admin-pages.about',[
                'about' =>  $about
            ]);
        } else {
            return view('admin-pages.about');
        }

    }
    public function aboutStore(Request $request)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:190'],
                'sub_title' =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('abouts','slug'),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The about page slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.about');
        }
        $imgPath = null;
        $about = new About();
        if ($request->image){
            $imgPath = $this->saveImage($request->image);

        }
        $about->title      = $request->title;
        $about->sub_title  = $request->sub_title;
        $about->slug       = $request->slug;
        $about->description= $request->description;
        $about->image      = $imgPath;
        $about->status     = 1;
        $about->save();

        Toastr::success('Successfully create about page!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.about');
    }
    public function aboutUpdate(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:190'],
                'sub_title' =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('abouts','slug')->ignore($id, "id"),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The about page slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.about');
        }
        $about = About::findOrFail($id);
        if ($request->image){
            if(Storage::disk('public')->exists("$about->image")) {
                Storage::disk('public')->delete("$about->image");
            }
            $imgPath = $this->saveImage($request->image);
            $about->image      = $imgPath;
        }
        $about->title      = $request->title;
        $about->sub_title  = $request->sub_title;
        $about->slug       = $request->slug;
        $about->description= $request->description;
        $about->status     = 1;
        $about->save();

        Toastr::success('Successfully update about page!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.about');
    }


    public function aboutWidgetIndex()
    {
        $about = AboutWidget::first();
        if ($about){
            return view('admin-pages.widget.about',[
                'about' =>  $about
            ]);
        } else {
            return view('admin-pages.widget.about');
        }

    }
    public function aboutWidgetStore(Request $request)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:190'],
                'sub_title' =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('about_widgets','slug'),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The about widget slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.widget.about');
        }
        $imgPath = null;
        if ($request->image){
            $imgPath = $this->saveImage($request->image);
        }
        $about = new AboutWidget();
        $about->title      = $request->title;
        $about->sub_title  = $request->sub_title;
        $about->slug       = $request->slug;
//        $about->description= $request->description;
        $about->image      = $imgPath;
        $about->status     = 1;
        $about->save();

        Toastr::success('Successfully create about widget!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.widget.about');
    }
    public function aboutWidgetUpdate(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:190'],
                'sub_title' =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('about_widgets','slug')->ignore($id, "id"),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The about widget slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.widget.about');
        }
        $about = AboutWidget::findOrFail($id);
        if ($request->image){
            if(Storage::disk('public')->exists("$about->image")) {
                Storage::disk('public')->delete("$about->image");
            }
            $imgPath = $this->saveImage($request->image);
            $about->image      = $imgPath;
        }
        $about->title      = $request->title;
        $about->sub_title  = $request->sub_title;
        $about->slug       = $request->slug;
//        $about->description= $request->description;
        $about->status     = 1;
        $about->save();

        Toastr::success('Successfully update about widget!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.widget.about');
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
