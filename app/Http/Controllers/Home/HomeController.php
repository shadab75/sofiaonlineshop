<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Order;
use App\Models\orderItem;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    //
    public function index()
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle('فروشگاه اینترنتی صوفیا');
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
        $sliders = Banner::query()->where('type','=','slider')->where('is_active','=',1)->orderBy('priority')->get();
        $indexTopBanners = Banner::query()->where('type','=','index_top')->where('is_active','=',1)->orderBy('priority')->get();
        $indexBottomBanners = Banner::query()->where('type','=','index_bottom')->where('is_active','=',1)->orderBy('priority')->get();
        $products = Product::query()->where('is_active','=',1)->inRandomOrder()->take(5)->get();
        $blogs = Blog::query()->where('is_active','=',1)->latest()->take(3)->get();
        $categories = Category::query()->where('is_active','=',1)->get();
        //bestsailing --> newest products not best selling
        $bestSailingProducts = Product::query()->where('is_active','=',1)->orderBy('id','desc')->take(5)->get();
        return view('home.index',compact('sliders','indexTopBanners','indexBottomBanners','products','categories','bestSailingProducts','blogs'));

    }

    public function aboutUs()
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle('درباره ما');
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
        $BottomBanners =  Banner::query()->where('type','=','index_bottom')->where('is_active','=',1)->orderBy('priority')->get();
        return view('home.about-us',compact('BottomBanners'));


    }

    public function contactUs()
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle('تماس با ما');
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
        $setting = Setting::query()->findOrFail(1);
        return view('home.contact-us',compact('setting'));
    }


    public function contactUsForm(Request $request)
    {

        $request->validate([
            'name'=>'required|string|min:4|max:50',
            'email'=>'required|email',
            'subject'=>'required|string|min:4|max:100',
            'text'=>'required|string|min:4|max:3000',
        ]);

        ContactUs::query()->create([
            'name'=>$request->name,
            'email'=>$request->email,
            'subject'=>$request->subject,
            'text'=>$request->text,
        ]);
        alert()->success('پیام شما با موفقیت ثبت شد','با تشکر');
        return redirect()->back();

    }

    public function latestProducts()
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle('جدید ترین محصولات');
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
        $products = Product::query()->where('is_active','=',1)->orderBy('id','desc')->paginate(10);
        return view('home.latest-products',compact('products'));
    }

    public function discountedProducts()
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle('پیشنهادات ویژه');
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
        $productsVariationIds =ProductVariation::query()->where('sale_price','!=',null)
            ->where('date_on_sale_from','<',Carbon::now())
            ->where('date_on_sale_to','>',Carbon::now())
            ->pluck('product_id')->toArray();

        $products = Product::query()->where('is_active','=',1)
            ->whereIn('id',$productsVariationIds)->paginate(10);


        return view('home.discounted-products',compact('products'));

    }

    public function return()
    {
        SEOMeta::addMeta('robots','index,follow');
        SEOTools::setTitle('شرایط مرجوعی');
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'fa');
        SEOTools::addImages(asset('/images/home/Logo.jpg'));
        SEOTools::twitter()->setSite('@sofiawomanwear');
        SEOTools::jsonLd()->setSite('sofia');
        return view('home.return');
    }
}
