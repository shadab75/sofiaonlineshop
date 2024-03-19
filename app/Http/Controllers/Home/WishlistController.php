<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    //
    public function add(Product $product)
    {
        if (auth()->check())
        {
            if ($product->checkUserWishList(auth()->id())){
                alert()->warning('محصول مورد نظر قبلا به لیست علاقه مندی شما اضافه شده است','دقت کنید' )->persistent('حله');
                return redirect()->back();
            }else{
                Wishlist::query()->create([
                   'user_id'=>auth()->id(),
                   'product_id'=>$product->id
                ]);
            }
            alert()->success('محصول مورد نظر به لیست علاقه مندی های شما اضافه شد','باتشکر' );
            return redirect()->back();
        }else{
            alert()->warning('برای افزودن به لیست علاقه مندی ها لازم است وارد وب سایت شوید','دقت کنید' )->persistent('حله');
            return redirect()->back();
        }
    }

    public function remove(Product $product)
    {
        if (auth()->check()){
        $wishList = Wishlist::query()->where('product_id',$product->id)->where('user_id','=',auth()->id())->firstOrFail();
        if ($wishList){
            Wishlist::query()->where('product_id',$product->id)->where('user_id','=',auth()->id())->delete();
        }
        alert()->success('محصول مورد نظر شما از لیست علاقه مندی حذف شد','باتشکر');
        return redirect()->back();
        }else{
            alert()->warning('برای حذف از لیست علاقه مندی ها لازم است وارد وب سایت شوید','دقت کنید' )->persistent('حله');
            return redirect()->back();
        }

    }

    public function usersProfileIndex()
    {
        SEOTools::setTitle('لیست علاقه مندی ها');
        SEOMeta::addMeta('robots','noindex,nofollow');
        $wishlist = Wishlist::query()->where('user_id','=',auth()->id())->get();
        return view('home.users_profile.wishlist',compact('wishlist'));
    }
}
