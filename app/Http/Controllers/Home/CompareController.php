<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class CompareController extends Controller
{
    //
    public function add(Product $product)
    {
    if (auth()->check()){
        if (session()->has('compareProducts')){
            if (in_array($product->id,session()->get('compareProducts'))){
                alert()->warning('محصول مورد نظر به لیست مقایسه شما قبلا اضافه شده است','دقت کنید');
                return redirect()->back();
            }
            session()->push('compareProducts',$product->id);

        }else{
            session()->put('compareProducts',[$product->id]);
        }

        alert()->success('محصول مورد نظر به لیست مقایسه شما اضافه شد','باتشکر');
        return redirect()->back();

    }else{
        alert()->warning('برای افزودن به لیست علاقه مندی ها لازم است وارد وب سایت شوید','دقت کنید' )->persistent('حله');
        return redirect()->back();
    }

    }

    public function index()
    {
        SEOTools::setTitle('لیست مقایسه ها');
        SEOMeta::addMeta('robots','noindex,nofollow');
        if (auth()->check()){
            if (session()->has('compareProducts')){
                $productIds =session()->get('compareProducts');
                $products = Product::query()->findOrFail($productIds);

                return view('home.users_profile.compare',compact('products'));
            }
            alert()->warning('در ابتدا باید محصولی برای مقایسه اضافه کنید','دقت کنید');
            return redirect()->back();
        }else{
            alert()->warning('برای افزودن به لیست علاقه مندی ها لازم است وارد وب سایت شوید','دقت کنید' )->persistent('حله');
            return redirect()->back();
        }

    }

    public function remove($productId)
    {
        if (auth()->check()){
            if (session()->has('compareProducts')){
                foreach (session()->get('compareProducts') as $key=>$item){
                    if ($item==$productId){
                        session()->pull('compareProducts.'.$key);
                    }
                }
                if (session()->get('compareProducts')==[]){
                    session()->forget('compareProducts');
                    return redirect()->route('home.index');

                }
                return redirect()->route('home.compare.index');

            }
            alert()->warning('در ابتدا باید محصولی برای مقایسه اضافه کنید','دقت کنید');
            return redirect()->back();
        }else{
            alert()->warning('برای افزودن به لیست علاقه مندی ها لازم است وارد وب سایت شوید','دقت کنید' )->persistent('حله');
            return redirect()->back();
        }
   }
}
