<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AboutWidget;
use App\Models\Blog;
use App\Models\ClientWidget;
use App\Models\GeneralSetting;
use App\Models\Media;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Service;
use App\Models\Slider;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getServiceMenus(){
//        $menus = Menu::approved()->select('id', 'main_menu','menu_name','slug')->with('services')->with('submenus')->get();
        $menus = Menu::approved()->select('id','menu_name','slug')->latest()->with('services')->get();

        if (!$menus->isEmpty()) {
            $response = [
                'success' => true,
                'data' => $menus,
                'total' => count($menus),
                'message' => 'Getting Menu Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Menu Found',
            ];
        }


        return response()->json($response, 200);
    }

//    public function getMenuServices($id){
//        $menuServices = Service::approved()->where('menu_id',$id)->latest()->get();
//
//        if (!$menuServices->isEmpty()) {
//            $response = [
//                'success' => true,
//                'data' => $menuServices,
//                'total' => count($menuServices),
//                'message' => 'Getting Menu Services Data',
//            ];
//        } else {
//            $response = [
//                'success' => false,
//                'message' => 'No Menu Services Found',
//            ];
//        }
//        return response()->json($response, 200);
//    }

    public function getService($id){
        $service = Service::approved()->find($id);

        if ($service) {
            $response = [
                'success' => true,
                'data' => $service,
                'message' => 'Getting Service Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Service Found',
            ];
        }

        return response()->json($response, 200);
    }

    public function getServices(){
        $services = Service::approved()->latest()->get();
        if (!$services->isEmpty()) {
            $response = [
                'success' => true,
                'data' => $services,
                'total' => count($services),
                'message' => 'Getting Services Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Services Found',
            ];
        }
        return response()->json($response, 200);
    }

    public function getSlider(){
        $slider = Slider::approved()->select('id','title','sub_title','slug','image')->latest()->get();
        if (!$slider->isEmpty()) {
            $response = [
                'success' => true,
                'data' => $slider,
                'total' => count($slider),
                'message' => 'Getting Slider Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Slider Found',
            ];
        }
        return response()->json($response, 200);
    }

    public function getProduct($id){
        $product = Product::approved()->find($id);
        if ($product) {
            $response = [
                'success' => true,
                'data' => $product,
                'message' => 'Getting Product Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Product Found',
            ];
        }
        return response()->json($response, 200);
    }

    public function getProducts(){
        $products = Product::approved()->latest()->get();
        if (!$products->isEmpty()) {
            $response = [
                'success' => true,
                'data' => $products,
                'total' => count($products),
                'message' => 'Getting Products Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Products Found',
            ];
        }
        return response()->json($response, 200);
    }

    public function getAbout(){
        $about = About::first()->get();
        if ($about) {
            $response = [
                'success'   => true,
                'data'      => $about,
                'message'   => 'Getting About Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No About Found',
            ];
        }
        return response()->json($response, 200);
    }

    public function getHomeAbout(){
        $about = AboutWidget::first()->select('id','title','sub_title','image')->get();
        if ($about) {
            $response = [
                'success' => true,
                'data' => $about,
                'message' => 'Getting Home About Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Home About Found',
            ];
        }
        return response()->json($response, 200);
    }

    public function getHomClient(){
        $client = ClientWidget::latest()->select('id','company_name','image')->get();
        if (!$client->isEmpty()) {
            $response = [
                'success' => true,
                'data' => $client,
                'message' => 'Getting client Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No client Found',
            ];
        }
        return response()->json($response, 200);
    }


    public function getNews(){
        $news = Blog::latest()->approved()->where('type','news')->get();
        if (!$news->isEmpty()) {
            $response = [
                'success' => true,
                'data' => $news,
                'total' => count($news),
                'message' => 'Getting News Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No News Found',
            ];
        }
        return response()->json($response, 200);
    }

    public function getEvent(){
        $event = Blog::latest()->approved()->where('type','event')->get();
        if (!$event->isEmpty()) {
            $response = [
                'success' => true,
                'data' => $event,
                'total' => count($event),
                'message' => 'Getting Event Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Event Found',
            ];
        }
        return response()->json($response, 200);
    }


    public function getBlog($id){
        $blog = Blog::approved()->findOrFail($id);
        if ($blog) {
            $response = [
                'success' => true,
                'data' => $blog,
                'message' => 'Getting Blog Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Blog Found',
            ];
        }
        return response()->json($response, 200);
    }

    public function getGallery(){
        $gallery = Media::get();
        if (!$gallery->isEmpty()) {
            $response = [
                'success' => true,
                'data' => $gallery,
                'message' => 'Getting Gallery Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Gallery Found',
            ];
        }
        return response()->json($response, 200);
    }
    public function getInfo(){
        $info = GeneralSetting::first();
        if ($info) {
            $response = [
                'success' => true,
                'data' => $info,
                'message' => 'Getting Info Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Info Found',
            ];
        }
        return response()->json($response, 200);
    }


}
