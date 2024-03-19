<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class ConditionsController extends Controller
{
    //
    public function index()
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle('قوانین و مقررات');
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
      return view('home.conditions');
    }
}
