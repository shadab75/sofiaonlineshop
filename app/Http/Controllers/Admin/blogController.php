<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class blogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $blogs = Blog::query()->latest()->paginate(20);
        return view('admin.blogs.index',compact('blogs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.blogs.create');
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
          'title'=>'required|unique:blogs,title',
          'keywords'=>'required',
          'body'=>'required',
          'is_active' => 'required',
          'image' => 'image|required|mimes:jpg,jpeg,png,svg|max:2048',
          'author'=>auth()->user()->name
       ]);
        $fileNameImage=generateFileName($request->image->getClientOriginalName());
        $request->image->move(public_path(env('BLOG_IMAGES_UPLOAD_PAT')),$fileNameImage);
        Blog::query()->create([
            'title'=>$request->title,
            'is_active'=>$request->is_active,
            'keywords'=>$request->keywords,
            'author'=>auth()->user()->name,
            'body'=>$request->body,
            'image'=>$fileNameImage
        ]);
        alert()->success('مقاله شما با موفقیت ایجاد شد', 'باتشکز');
        return redirect()->route('admin.blogs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
        return view('admin.blogs.show',compact('blog'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
        return view('admin.blogs.edit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Blog $blog)
    {
        //


        $request->validate([
            'title'=>'required|unique:blogs,title,'.$blog->id,
            'body'=>'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,svg|max:2048',
            'keywords'=>'required',
            'is_active'=>'required'
            ]);
        if ($request->has('image')){

            $fileNameImage=generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path(env('BLOG_IMAGES_UPLOAD_PAT')),$fileNameImage);
        }
        $blog->update([
            'image'=>$request->has('image') ? $fileNameImage:$blog->image,
            'title'=>$request->title,
            'body'=>$request->body,
            'keywords'=>$request->keywords,
            'is_active'=>$request->is_active,

        ]);
        alert()->success('با تشکر', 'مقاله شما با موفقیت ویرایش شد');
        return redirect()->route('admin.blogs.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
