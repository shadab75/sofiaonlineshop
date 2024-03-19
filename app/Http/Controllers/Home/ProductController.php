<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    //
    public function show(Product $product)
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle($product->name);
        SEOTools::setDescription($product->description);
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::opengraph()->setSiteName('sofia');
        SEOMeta::setKeywords( explode(',',$product->keywords));
        SEOTools::addImages(asset($product->primary_image));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
        $similarProducts = Product::all();

       return view('home.products.show',compact('product','similarProducts'));
    }
}
