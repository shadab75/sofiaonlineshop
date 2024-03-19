<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Province;
use App\Models\UserAddress;
use Artesaos\SEOTools\Facades\SEOMeta;

use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;


class CartController extends Controller
{
    //
    public function add(Request $request)
    {
        $request->validate([
           'product_id'=>'required',
           'qtybutton'=>'required'
        ]);
        $product = Product::query()->findOrFail($request->product_id);
        $productVariation = ProductVariation::query()->findOrFail(json_decode($request->variation)->id);
        if ($request->qtybutton>$productVariation->quantity){
            alert()->error('اطلاعات وارد شده از محصول درست نمیباشد','باتشکر');
            return redirect()->back();
        }
        $rowId = $product->id.'-'.$productVariation->id;

        if (\Cart::get($rowId)==null){
            \Cart::add(array(
                'id'=>$rowId,
                'name'=>$product->name,
                'price'=>$productVariation->is_sale?$productVariation->sale_price:$productVariation->price,
                'quantity'=>$request->qtybutton,
                'attributes'=>$productVariation->toArray(),
                'associatedModel'=>$product
            ));
        }else{
            alert()->warning('محصول مورد نظر در سبد خرید شما وجود دارد','دقت کنید');
            return redirect()->back();
        }
        alert()->success('محصول مورد نظر به سبد خرید شما اضافه شد','باتشکر');
        return redirect()->back();

    }

    public function index()
    {
        SEOMeta::addMeta('robots','noindex,nofollow');
        SEOTools::setTitle('سبد خرید');
        return view('home.cart.index');
    }
    public function update(Request $request)
    {
        $request->validate([
           'qtybutton'=>'required'
        ]);
        foreach ($request->qtybutton as $rowId=>$quantity){
            $item = \Cart::get($rowId);
            if ($quantity>$item->attributes->quantity){
                alert()->error('تعداد وارد شده از محصول درست نمیباشد','دقت کنید');
                return redirect()->back();
            }
            \Cart::update($rowId,array(
                'quantity'=>array(
                 'relative'=>false,
                 'value'=>$quantity
                ),
            ));
        }
        alert()->success('سبد خرید شما ویرایش شد ','باتشکر');
        return redirect()->back();
//        ->with(['message' => 'سبد خرید شما به روز شد'])
    }

    public function remove($rowId)
    {
    \Cart::remove($rowId);

    return redirect()->back();
    }
    public function clear()
    {
        \Cart::clear();
        alert()->warning('سبد خرید شما خالی شد','باتشکر');
        return redirect()->back();
//        ->with(['message' => 'سبد خرید شما به روز شد'])
    }

    public function checkCoupon(Request $request)
    {
        $request->validate([
           'code'=>'required'
        ]);
        if (!auth()->check()){
            alert()->error('برای استفاده از کد تخفیف باید ابتدا وارد وبسایت شوید','دقت کنید');
            return redirect()->back();
        }
        $result = checkCoupon($request->code);
        if (array_key_exists('error',$result)){
            alert()->error($result['error'],'دقت کنید');

        }else{
            alert()->success($result['success'],'باتشکر');
        }
        return redirect()->back();
    }
    function checkout()
    {
        SEOTools::setTitle('تسویه حساب');
        SEOMeta::addMeta('robots','noindex,nofollow');

        if (\Cart::isEmpty()){
            alert()->warning('سبد خرید شما خالی میباشد','دقت کنید');
            return redirect()->home('home.index');
        }
        $addresses = UserAddress::query()->where('user_id','=',auth()->id())->get();
        $provinces = Province::all();
       return view('home.cart.checkout',compact('addresses','provinces'));
    }

    public function usersProfileIndex()
    {
        SEOTools::setTitle('سفارشات');
        SEOMeta::addMeta('robots','noindex,nofollow');

        $orders = Order::query()->where('user_id','=',auth()->id())->get();
        return view('home.users_profile.orders',compact('orders'));
    }
}
