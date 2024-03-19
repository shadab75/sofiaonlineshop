<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $banners = Banner::latest()->paginate(20);
        return view('admin.banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


       $request->validate([
           'image' => 'required|mimes:jpg,jpeg,png,svg',
           'priority'=>'required|integer',
           'type'=>'required'

       ]);
       $fileNameImage=generateFileName($request->image->getClientOriginalName());
       $request->image->move(public_path(env('BANNER_IMAGES_UPLOAD_PAT')),$fileNameImage);
        Banner::query()->create([
            'image'=>$fileNameImage,
            'title'=>$request->title,
            'text'=>$request->text,
            'priority'=>$request->priority,
            'is_active'=>$request->is_active,
            'type'=>$request->type,
            'button_text'=>$request->button_text,
            'button_link'=>$request->button_link,
            'button_icon'=>$request->button_icon,
            'alt'=>$request->alt
        ]);
        alert()->success('بنر شما با موفقیت ایجاد شد', 'باتشکز');
        return redirect()->route('admin.banners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        //
        return view('admin.banners.edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        //

        $request->validate([
            'image' => 'nullable|mimes:jpg,jpeg,png,svg|max:2048',
            'priority'=>'required|integer',
            'type'=>'required'

        ]);
        if ($request->has('image')){

            $fileNameImage=generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path(env('BANNER_IMAGES_UPLOAD_PAT')),$fileNameImage);
        }

        $banner->update([
            'image'=>$request->has('image') ? $fileNameImage:$banner->image,
            'title'=>$request->title,
            'text'=>$request->text,
            'priority'=>$request->priority,
            'is_active'=>$request->is_active,
            'type'=>$request->type,
            'button_text'=>$request->button_text,
            'button_link'=>$request->button_link,
            'button_icon'=>$request->button_icon,
            'alt'=>$request->alt
        ]);
        alert()->success('با تشکر', 'بنر شما با موفقیت ویرایش شد');
        return redirect()->route('admin.banners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        //
        $banner->delete();
        alert()->success('با تشکر', 'بنر شما با موفقیت حذف شد');
        return redirect()->route('admin.banners.index');
    }


}
