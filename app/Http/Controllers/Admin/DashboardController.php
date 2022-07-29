<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }
    public function setting(){
        return view('admin-pages.setting',[
            'setting' => GeneralSetting::first()
        ]);
    }
    public function generalSetting(Request $request){
        if (!GeneralSetting::first()){
            $generalSetting =  new GeneralSetting();
            $generalSetting->about          = $request->about;
            $generalSetting->telephone      = $request->telephone;
            $generalSetting->mobile         = $request->mobile;
            $generalSetting->email          = $request->email;
            $generalSetting->inquiries_email= $request->inquiries_email;
            $generalSetting->facebook       = $request->facebook;
            $generalSetting->linkedin       = $request->linkedin;
            $generalSetting->twitter        = $request->twitter;
            $generalSetting->address        = $request->address;
            $generalSetting->contact_address= $request->contact_address;
            $generalSetting->save();
            Toastr::success('General Setting updated successful!', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('admin.general.setting');
        }else{
            $generalSetting =  GeneralSetting::first();
            $generalSetting->about          = $request->about;
            $generalSetting->telephone      = $request->telephone;
            $generalSetting->mobile         = $request->mobile;
            $generalSetting->email          = $request->email;
            $generalSetting->inquiries_email= $request->inquiries_email;
            $generalSetting->facebook       = $request->facebook;
            $generalSetting->linkedin       = $request->linkedin;
            $generalSetting->twitter        = $request->twitter;
            $generalSetting->address        = $request->address;
            $generalSetting->contact_address= $request->contact_address;
            $generalSetting->save();
            Toastr::success('General Setting updated successful!', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('admin.setting');
        }
    }

}
