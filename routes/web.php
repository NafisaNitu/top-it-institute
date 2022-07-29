<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\WidgetsController;
use App\Http\Controllers\Admin\ServicController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SubjectController;



Route::get('/clear-cache', function() {
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('view:clear');
    $run = Artisan::call('storage:link');
    $run = Artisan::call('config:clear');
    $run = Artisan::call('config:cache');

//    $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
//    if (file_exists($targetFolder)) {
//        return 'The public/storage link already exists.';
//    }
//    else {
//        $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
//        app('files')->link(storage_path('app/public'), $linkFolder);
//        return 'storage linked successful.';
//    }
});



Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware'=>['auth'],'prefix'=>'admin','as'=>'admin.'],function(){
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/setting', [DashboardController::class,'setting'])->name('setting');
    Route::post('/general-setting', [DashboardController::class,'generalSetting'])->name('general.setting');

    Route::get('/ajax-submenu/{id}', [MenuController::class,'ajaxSubmenu']);

    Route::get('/menus', [MenuController::class,'index'])->name('menus');
    Route::post('/menu-create', [MenuController::class,'storeMenu'])->name('create.menu');
    Route::get('/menu-edit/{id}', [MenuController::class,'editMenu'])->name('edit.menu');
    Route::put('/menu-update/{id}', [MenuController::class,'updateMenu'])->name('update.menu');
    Route::delete('/menu-delete/{id}', [MenuController::class,'destroyMenu'])->name('destroy.menu');

//    Category Modules
    Route::get('/categories',[CategoryController::class,'index'])->name('categories');
    Route::post('/category-create',[CategoryController::class,'storeCategory'])->name('create.menu');






    Route::post('/sub-menus-create', [MenuController::class,'storeSubMenu'])->name('create.submenu');
    Route::get('/sub-menu-edit/{id}', [MenuController::class,'editSubMenu'])->name('edit.submenu');
    Route::put('/sub-menu-update/{id}', [MenuController::class,'updateSubMenu'])->name('update.submenu');
    Route::delete('/sub-menus-delete/{id}', [MenuController::class,'destroySubMenu'])->name('destroy.submenu');

    Route::get('/sliders', [SliderController::class,'index'])->name('sliders');
    Route::post('/slider-create', [SliderController::class,'store'])->name('create.slider');
    Route::delete('/slider-delete/{id}', [SliderController::class,'destroy'])->name('destroy.slider');
    Route::get('/slider-edit/{id}', [SliderController::class,'edit'])->name('edit.slider');
    Route::put('/slider-update/{id}', [SliderController::class,'update'])->name('update.slider');

    Route::get('/widget-about', [AboutController::class,'aboutWidgetIndex'])->name('widget.about');
    Route::post('/widget-about-create', [AboutController::class,'aboutWidgetStore'])->name('create.widget.about');
    Route::put('/widget-about-update/{id}', [AboutController::class,'aboutWidgetUpdate'])->name('update.widget.about');

    Route::get('/widget-clients', [WidgetsController::class,'clients'])->name('widget.clients');
    Route::post('/widget-clients-create', [WidgetsController::class,'clientStore'])->name('create.widget.clients');
    Route::delete('/widget-clients-delete/{id}', [WidgetsController::class,'clientDestroy'])->name('destroy.widget.clients');

    //Subject Modules
    Route::get('/subjects', [SubjectController::class,'index'])->name('subjects');
    Route::get('/subject-create', [SubjectController::class,'create']);
    Route::post('/subject-create', [SubjectController::class,'store'])->name('create.subject');
    Route::get('/subject-edit/{id}', [SubjectController::class,'edit'])->name('edit.subject');
    Route::put('/subject-update/{id}', [SubjectController::class,'update'])->name('update.subject');
    Route::delete('/subject-delete/{id}', [SubjectController::class,'destroy'])->name('destroy.subject');


    Route::get('/services', [ServicController::class,'index'])->name('services');
    Route::get('/service-create', [ServicController::class,'create']);
    Route::post('/service-create', [ServicController::class,'store'])->name('create.service');
    Route::get('/service-edit/{id}', [ServicController::class,'edit'])->name('edit.service');
    Route::put('/service-update/{id}', [ServicController::class,'update'])->name('update.service');
    Route::delete('/service-delete/{id}', [ServicController::class,'destroy'])->name('destroy.service');


    Route::get('/blogs', [BlogController::class,'index'])->name('blogs');
    Route::get('/blog-create', [BlogController::class,'create']);
    Route::post('/blog-create', [BlogController::class,'store'])->name('create.blog');
    Route::get('/blog-edit/{id}', [BlogController::class,'edit'])->name('edit.blog');
    Route::put('/blog-update/{id}', [BlogController::class,'update'])->name('update.blog');
    Route::delete('/blog-delete/{id}', [BlogController::class,'destroy'])->name('destroy.blog');


    Route::get('/products', [ProductController::class,'index'])->name('products');
    Route::get('/product-create', [ProductController::class,'create']);
    Route::post('/product-create', [ProductController::class,'store'])->name('create.product');
    Route::get('/product-edit/{id}', [ProductController::class,'edit'])->name('edit.product');
    Route::put('/product-update/{id}', [ProductController::class,'update'])->name('update.product');
    Route::delete('/product-delete/{id}', [ProductController::class,'destroy'])->name('destroy.product');


    Route::get('/medias', [MediaController::class,'index'])->name('medias');
    Route::get('/media-create', [MediaController::class,'create']);
    Route::post('/media-create', [MediaController::class,'store'])->name('create.media');
    Route::delete('/media-delete/{id}', [MediaController::class,'destroy'])->name('destroy.media');


    Route::get('/page/about', [AboutController::class,'aboutIndex'])->name('about');
    Route::post('/page/about/create', [AboutController::class,'aboutStore'])->name('create.about');
    Route::put('/page/about/update/{id}', [AboutController::class,'aboutUpdate'])->name('update.about');








});
