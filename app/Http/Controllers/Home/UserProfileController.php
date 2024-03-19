<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    //
    public function index()
    {
        SEOTools::setTitle('پروفایل');
        SEOMeta::addMeta('robots','noindex,nofollow');
        return view('home.users_profile.index');
    }
}
