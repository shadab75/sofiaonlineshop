<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Tag;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function show(Tag $tag)
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle($tag->name);
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::opengraph()->setSiteName('sofia');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
        SEOTools::twitter()->setSite('@sofiawomanwear');

        $products = $tag->products()->paginate(10);
      return view('home.tags.show',compact('products'));


    }
}
