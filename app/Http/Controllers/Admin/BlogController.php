<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Service;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{

    public function index()
    {
        return view('admin-pages.blog.blogs',[
            'blogs' =>  Blog::latest()->paginate(10)
        ]);
    }


    public function create()
    {
        return view('admin-pages.blog.create');
    }


    public function store(Request $request)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:90'],
                'sub_title' =>  ['required', 'string'],
                'type'      =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('blogs','slug'),],
                'image'     =>  ['mimes:webp,svgpng,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The blog slug has already has taken.',
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

        $blog = new Blog();
        $blog->title        = $request->title;
        $blog->sub_title    = $request->sub_title;
        $blog->slug         = $request->slug;
        $blog->type         = $request->type;
        $blog->description  = $request->description;
        $blog->image        = $imgPath;
        $blog->status       = $request->status == null ? 0 : $request->status;
        $blog->save();

        Toastr::success('Successfully create a new blog', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.blogs');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin-pages.blog.create',[
            'blog'  =>  $blog
        ]);
    }


    public function update(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:90'],
                'sub_title' =>  ['required', 'string'],
                'type'      =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('blogs','slug')->ignore($id, "id"),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The blog slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->back();
        }
        $blog = Blog::findOrFail($id);
        if ($request->image){
            if(Storage::disk('public')->exists("$blog->image")) {
                Storage::disk('public')->delete("$blog->image");
            }
            $imgPath = $this->saveImage($request->image);
            $blog->image         = $imgPath;
        }

        $blog->title        = $request->title;
        $blog->sub_title    = $request->sub_title;
        $blog->slug         = $request->slug;
        $blog->type         = $request->type;
        $blog->description  = $request->description;
        $blog->status       = $request->status == null ? 0 : $request->status;
        $blog->save();

        Toastr::success('Blog update successful!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.blogs');
    }


    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if(Storage::disk('public')->exists("$blog->image")) {
            Storage::disk('public')->delete("$blog->image");
        }
        $blog->delete();
        Toastr::success('Successfully delete blog!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.blogs');
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
