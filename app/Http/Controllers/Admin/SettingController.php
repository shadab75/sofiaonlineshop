<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function index()
    {
        $settings = Setting::all();
        return view('admin.setting.index',compact('settings'));

    }
    public function show(Setting $setting)
    {

        return view('admin.setting.show',compact('setting'));

    }


    public function edit(Setting $setting)
    {
        return view('admin.setting.edit',compact('setting'));
    }

    public function update(Request $request,Setting $setting)
    {

    $setting->update([
    'address'=>$request->address,
    'telephone'=>$request->telephone1,
    'telephone2'=>$request->telephone2,
    'email'=>$request->email,
    'longitude'=>$request->longitude,
    'latitude'=>$request->latitude,
    'workinghours'=>$request->workinghours,
    'description'=>$request->description,
    ]);
        alert()->success('تماس با ما موفقیت ویرایش شد', 'باتشکر');
        return redirect()->route('admin.setting.index');
    }
}
