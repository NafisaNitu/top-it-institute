<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MenuDataTable;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\SubMenu;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class MenuController extends Controller
{

    public function ajaxSubmenu($id)
    {
        return SubMenu::approved()->where('menu_id',$id)->get();
    }

    public function index()
    {
        return view('admin-pages.menus',[
            'formMenus' => Menu::latest()->get(),
            'menus' => Menu::latest()->paginate(10),
            'submenus' => SubMenu::latest()->paginate(10),
        ]);
    }

    public function storeMenu(Request $request)
    {
        $request['slug'] = Str::slug($request->menu_name);
        $validator = Validator::make($request->all(),
            [
                'main_menu' =>  ['required', 'string'],
                'menu_name' =>  ['required', 'string', 'max:40'],
                'slug'      =>  [Rule::unique('menus','slug'),]
            ],
            [
                'slug.unique' => 'The menu slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.menus');
        }
        $imgPath = null;
        if ($request->image){
            $imgPath = $this->saveImage($request->image);
        }
        $menu = new Menu();
        $menu->main_menu    = $request->main_menu;
        $menu->menu_name    = $request->menu_name;
        $menu->slug         = $request->slug;
        $menu->status       = $request->status == null ? 0 : $request->status;;
        $menu->image        = $imgPath;
        $menu->save();
        Toastr::success('Successfully create a new menu!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.menus');
    }

    public function storeSubMenu(Request $request)
    {
        $request['slug'] = Str::slug($request->name);
        $validator = Validator::make($request->all(),
            [
                'menu_id'   =>  ['required'],
                'name'      =>  ['required', 'string', 'max:40'],
                'slug'      =>  [Rule::unique('sub_menus','slug'),]
            ],
            [
                'slug.unique' => 'The submenu slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.menus');
        }
        $imgPath = null;
        if ($request->image){
            $imgPath = $this->saveImage($request->image);
        }
        $submenu = new SubMenu();
        $submenu->menu_id      = $request->menu_id;
        $submenu->name         = $request->name;
        $submenu->slug         = $request->slug;
        $submenu->status       = $request->status == null ? 0 : $request->status;
        $submenu->image        = $imgPath;
        $submenu->save();
        Toastr::success('Successfully create a new submenu!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.menus');
    }


    public function store(Request $request)
    {
        //
    }


    public function getMenus()
    {
        return DataTables::of(Menu::query())->make(true);
    }


    public function editMenu($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin-pages.menus',[
            'formMenus' => Menu::latest()->get(),
            'menus' => Menu::latest()->paginate(10),
            'submenus' => SubMenu::latest()->paginate(10),
            'getMenu' => $menu,
        ]);

    }

    public function editSubMenu($id)
    {
        $submenu = SubMenu::findOrFail($id);
        return view('admin-pages.menus',[
            'formMenus' => Menu::latest()->get(),
            'menus' => Menu::latest()->paginate(10),
            'submenus' => SubMenu::latest()->paginate(10),
            'getSubMenu' => $submenu,
        ]);

    }


    public function updateMenu(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->menu_name);
        $validator = Validator::make($request->all(),
            [
                'main_menu' =>  ['required', 'string'],
                'menu_name' =>  ['required', 'string', 'max:40'],
                'slug'      =>  [Rule::unique('menus','slug')->ignore($id, "id"),]
            ],
            [
                'slug.unique' => 'The menu slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.menus');
        }
        $menu = Menu::findOrFail($id);
        if ($request->image){
            if(Storage::disk('public')->exists("$menu->image")) {
                Storage::disk('public')->delete("$menu->image");
            }
            $imgPath = $this->saveImage($request->image);
            $menu->image        = $imgPath;
        }
        $menu->main_menu    = $request->main_menu;
        $menu->menu_name    = $request->menu_name;
        $menu->slug         = $request->slug;
        $menu->status       = $request->status == null ? 0 : $request->status;

        $menu->save();
        Toastr::success('Menu updated successful!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.menus');

    }

    public function updateSubMenu(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->name);
        $validator = Validator::make($request->all(),
            [
                'menu_id'   =>  ['required'],
                'name'      =>  ['required', 'string', 'max:40'],
                'slug'      =>  [Rule::unique('sub_menus','slug')->ignore($id, "id"),]
            ],
            [
                'slug.unique' => 'The submenu slug has already has taken.',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error){
                Toastr::error(Arr::first(Arr::flatten($error)), 'Error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->route('admin.menus');
        }
        $submenu = SubMenu::findOrFail($id);
        if ($request->image){
            if(Storage::disk('public')->exists("$submenu->image")) {
                Storage::disk('public')->delete("$submenu->image");
            }
            $imgPath = $this->saveImage($request->image);
            $submenu->image        = $imgPath;
        }
        $submenu->menu_id      = $request->menu_id;
        $submenu->name         = $request->name;
        $submenu->slug         = $request->slug;
        $submenu->status       = $request->status == null ? 0 : $request->status;
        $submenu->save();
        Toastr::success('Submenu updated successful!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.menus');

    }


    public function destroyMenu($id)
    {
        $menu = Menu::findOrFail($id);
        if(Storage::disk('public')->exists("$menu->image")) {
            Storage::disk('public')->delete("$menu->image");
        }
        $menu->delete();
        Toastr::success('Successfully delete menu!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.menus');

    }
    public function destroySubMenu($id)
    {
        $subMenu = SubMenu::findOrFail($id);
        if(Storage::disk('public')->exists("$subMenu->image")) {
            Storage::disk('public')->delete("$subMenu->image");
        }
        $subMenu->delete();
        Toastr::success('Successfully delete submenu!', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.menus');
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
