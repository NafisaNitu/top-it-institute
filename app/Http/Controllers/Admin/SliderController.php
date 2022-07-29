<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Toastr;

class SliderController extends Controller
{

    public function index()
    {
        return view('admin-pages.slider',[
            'sliders'   =>  Slider::latest()->paginate(10),
        ]);
    }


    public function store(Request $request)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:30'],
                'sub_title' =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('sliders','slug'),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The slider slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.sliders');
        }
        $imgPath = null;
        if ($request->image){
            $imgPath = $this->saveImage($request->image);
        }
        $slider = new Slider();
        $slider->title      = $request->title;
        $slider->sub_title  = $request->sub_title;
        $slider->slug       = $request->slug;
        $slider->image      = $imgPath;
        $slider->status     = $request->status == null ? 0 : $request->status;
        $slider->save();

        Toastr::success('Successfully create a new slider!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.sliders');

    }


    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin-pages.slider',[
            'sliders'   =>  Slider::latest()->paginate(10),
            'slider'    =>  $slider,
        ]);
    }


    public function update(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:30'],
                'sub_title' =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('sliders','slug')->ignore($id, "id"),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The slider slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.sliders');
        }
        $slider = Slider::findOrFail($id);
        if ($request->image){
            if(Storage::disk('public')->exists("$slider->image")) {
                Storage::disk('public')->delete("$slider->image");
            }
            $imgPath = $this->saveImage($request->image);
            $slider->image      = $imgPath;
        }
        $slider->title      = $request->title;
        $slider->sub_title  = $request->sub_title;
        $slider->slug       = $request->slug;
        $slider->status     = $request->status == null ? 0 : $request->status;
        $slider->save();

        Toastr::success('Slider updated successfully!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.sliders');

    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        if(Storage::disk('public')->exists("$slider->image")) {
            Storage::disk('public')->delete("$slider->image");
        }
        $slider->delete();
        Toastr::success('Successfully delete slider!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.sliders');
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
