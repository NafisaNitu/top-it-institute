<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientWidget;
use App\Models\Menu;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WidgetsController extends Controller
{
    public function clients(){
        return view('admin-pages.widget.clients',[
            'clients'   =>  ClientWidget::latest()->paginate(10)
        ]);
    }
    public function clientStore(Request $request){
        $validator = Validator::make($request->all(),
            [
                'company_name'  =>  ['required', 'string'],
                'image'         =>  ['required', 'mimes:webp,svg,png,jpeg,jpg','max:20000']
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.widget.clients');
        }
        $imgPath = null;
        if ($request->image){
            $imgPath = $this->saveImage($request->image);
        }
        $client = new ClientWidget();
        $client->company_name = $request->company_name;
        $client->status       = 1;
        $client->image        = $imgPath;
        $client->save();
        Toastr::success('Successfully create a client!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.widget.clients');
    }

    public function clientDestroy($id)
    {
        $client = ClientWidget::findOrFail($id);
        if(Storage::disk('public')->exists("$client->image")) {
            Storage::disk('public')->delete("$client->image");
        }
        $client->delete();
        Toastr::success('Successfully delete client!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.widget.clients');
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
