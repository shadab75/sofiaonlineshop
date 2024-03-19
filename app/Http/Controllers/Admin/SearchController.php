<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use GuzzleHttp\Psr7\Request;

class SearchController extends Controller
{
    //
    public function index()
    {


    $keyword = trim(request()->userSearch);

    $products = Product::all()->where('is_active','=',1);

    if ($keyword!=''){
        $products = Product::query()->where('name','like','%' . $keyword . '%')
            ->where('is_active','=','1')->paginate(10);

    }
    if (count($products)==0){
        alert()->error('متاسفانه محصول مورد نظر پیدا نشد');
        return redirect()->back();
    }
     return view('home.search',compact('products'));

    }

    public function mobileSearch()
    {
        $keyword = trim(request()->userSearch);
        $products = Product::all()->where('is_active','=',1);
        if ($keyword!=''){
            $products = Product::query()->where('name','like','%' . $keyword . '%')
                ->where('is_active','=','1')->paginate(10);

        }
        if (count($products)==0){
            alert()->error('متاسفانه محصول مورد نظر پیدا نشد');
            return redirect()->back();
        }
        return view('home.search',compact('products'));
    }

}
