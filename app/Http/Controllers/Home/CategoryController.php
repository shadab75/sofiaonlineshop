<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    //
    public function show(Request $request , Category $category)
    {
        SEOTools::setTitle($category->name);
        SEOTools::setDescription($category->description);
        SEOMeta::setKeywords(explode(',',$category->keywords));
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::opengraph()->addProperty('site_name', 'صوفیا');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
       $attributes = $category->attributes()->where('is_filter','=',1)->with('values')->get();
       $variation = $category->attributes()->where('is_variation','=',1)->with('variationValues')->first();
       $products = $category->products()->filter()->search()->paginate(10);
       return view('home.categories.show',compact('category','attributes','variation','products'));
    }
}
