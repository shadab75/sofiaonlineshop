<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function show(Blog $blog)
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle($blog->title);
        SEOTools::setDescription($blog->body);
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::opengraph()->setSiteName('sofia');
        SEOMeta::setKeywords( explode(',',$blog->keywords));
        SEOTools::addImages(asset($blog->image));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
      return view('home.blogs.show',compact('blog'));

    }

    public function index()
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle('مقالات');
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
        $blogs = Blog::query()->where('is_active','=',1)->orderBy('id')->paginate(10);
        return view('home.blogs.index',compact('blogs'));

    }
}
