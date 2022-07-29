<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientWidget;
use App\Models\Media;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{

    public function index()
    {
        return view('admin-pages.medias',[
            'medias'    =>  Media::latest()->paginate()
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'image' =>  ['required', 'mimes:webp,svg,png,jpeg,jpg','max:20000']
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.medias');
        }
        $imgPath = null;
        if ($request->image){
            $imgPath = $this->saveImage($request->image);
        }
        $media = new Media();
        $media->label   = $request->label;
        $media->image   = $imgPath;
        $media->save();
        Toastr::success('Successfully create a media!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.medias');
    }


    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        if(Storage::disk('public')->exists("$media->image")) {
            Storage::disk('public')->delete("$media->image");
        }
        $media->delete();
        Toastr::success('Successfully delete media!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.medias');
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
