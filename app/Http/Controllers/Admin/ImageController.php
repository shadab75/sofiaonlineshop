<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    public function store(Request $request)
    {
        $blog = new Blog();
        $blog->id = 0;
        $blog->exists = True;
        $image = $blog->addMediaFromRequest('upload')->toMediaCollection('images');


        $url = $image->original_url;
        return response()->json([

            'url'=>$url
        ]);
    }
}

