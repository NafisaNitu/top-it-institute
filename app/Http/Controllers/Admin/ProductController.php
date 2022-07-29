<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Service;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    public function index()
    {
        return view('admin-pages.product.products',[
            'products'  =>  Product::latest()->paginate(10),
        ]);
    }


    public function create()
    {
        return view('admin-pages.product.create');
    }


    public function store(Request $request)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:90'],
                'sub_title' =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('products','slug'),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The product slug has already has taken.',
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

        $product = new Product();
        $product->title        = $request->title;
        $product->sub_title    = $request->sub_title;
        $product->slug         = $request->slug;
        $product->description  = $request->description;
        $product->image        = $imgPath;
        $product->status       = $request->status == null ? 0 : $request->status;
        $product->save();

        Toastr::success('Successfully create a new product!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.products');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin-pages.product.create',[
            'product'   =>  $product
        ]);
    }


    public function update(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->title);
        $validator = Validator::make($request->all(),
            [
                'title'     =>  ['required', 'string', 'max:90'],
                'sub_title' =>  ['required', 'string'],
                'slug'      =>  [Rule::unique('products','slug')->ignore($id, "id"),],
                'image'     =>  ['mimes:webp,svg,png,jpeg,jpg','max:20000']
            ],
            [
                'slug.unique' => 'The product slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->back();
        }
        $product = Product::findOrFail($id);
        if ($request->image){
            if(Storage::disk('public')->exists("$product->image")) {
                Storage::disk('public')->delete("$product->image");
            }
            $imgPath = $this->saveImage($request->image);
            $product->image         = $imgPath;
        }

        $product->title        = $request->title;
        $product->sub_title    = $request->sub_title;
        $product->slug         = $request->slug;
        $product->description  = $request->description;
        $product->status       = $request->status == null ? 0 : $request->status;
        $product->save();

        Toastr::success('Product update Successful!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.products');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if(Storage::disk('public')->exists("$product->image")) {
            Storage::disk('public')->delete("$product->image");
        }
        $product->delete();
        Toastr::success('Product delete successful!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.products');
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
