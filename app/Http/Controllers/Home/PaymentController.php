<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\orderItem;
use App\Models\ProductVariation;
use App\Models\Transaction;
use App\PaymentGateway\Zarinpal;
use App\PaymentGateway\Payment;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shetabit\Multipay\Invoice;

class PaymentController extends Controller
{
   function payment(Request $request)
   {
//       alert()->warning('فعلا امکان خرید از فروشگاه فراهم نمیباشد','دقت کنید');

//       return redirect()->route('home.index');
    if (auth()->user()->name==null)
    {
        alert()->warning('نام و نام خانوادگی خود را وارد کنید','دقت کنید')->persistent('باشه');
        return redirect()->route('home.users_profile.index');

    }
    else{
        $validator = validator()->make($request->all(), [
            'address_id' => 'required',
            'payment_method' => 'required',
        ]);
        if ($validator->fails()) {
            alert()->error('انتخاب آدرس سفارش الزامی میباشد', 'دقت کنید')->persistent('حله');
            return redirect()->back();
        }
        $checkCart = $this->checkCart();
        if (array_key_exists('error', $checkCart)) {
            alert()->error($checkCart['error'], 'دقت کنید');
            return redirect()->route('home.index');
        }
        $amounts = $this->getAmounts();
        if (array_key_exists('error', $amounts)) {
            alert()->error($amounts['error'], 'دقت کنید');
            return redirect()->route('home.index');
        }
        $zarinpalGateway = new Zarinpal();
        $zarinpalGatewayResult = $zarinpalGateway->send($amounts,$description = 'خرید تستی',$request->address_id);

        if (array_key_exists('error', $zarinpalGatewayResult)) {
            alert()->error($zarinpalGatewayResult['error'], 'دقت کنید')->persistent('حله');
            return redirect()->back();
        }else{
            return redirect()->to($zarinpalGatewayResult['success']);
        }
    }

   }


    public function paymentVerify(Request $request)
    {
        $amounts = $this->getAmounts();
        if (array_key_exists('error', $amounts)) {
            alert()->error($amounts['error'], 'دقت کنید');
            return redirect()->route('home.index');
        }
        $zarinpalGateway = new Zarinpal();
        $zarinpalGatewayResult = $zarinpalGateway->verify($request->Authority,$amounts['paying_amount']);

        if (array_key_exists('error', $zarinpalGatewayResult)) {
            alert()->error($zarinpalGatewayResult['error'], 'دقت کنید')->persistent('حله');
            return redirect()->back();
        }else{
            alert()->success($zarinpalGatewayResult['success'],'با تشکر')->persistent('حله');
            return redirect()->route('home.orders.users_profile.index');
        }

    }



    function checkCart()
    {
     if (\Cart::isEmpty())
     {
         return ['error'=>'سبد خرید شما خالی میباشد'];
     }
     foreach (\Cart::getContent() as $item)
     {
         $variation = ProductVariation::query()->find($item->attributes->id);
         $price = $variation->is_sale?$variation->sale_price:$variation->price;
         if ($item->price!=$price){
             \Cart::clear();
             return ['error'=>'قیمت خرید تغییر کرده است'];

         }
         if ($item->quantity>$variation->quantity){
             \Cart::clear();
             return ['error'=>'موجودی محصول تغییر کرده است'];

         }
         return ['success'=>'success!'];
     }
    }
    function getAmounts()
    {
        if (session()->has('coupon')){

            $checkCoupon=checkCoupon(session()->get('coupon.code'));
            if (array_key_exists('error',$checkCoupon))
            {

                return $checkCoupon;
            }
        }

        return [
            'total_amounts'=>(\Cart::getTotal()+cartTotalSaleAmount()),
            'delivery_amount'=>cartTotalDeliveryAmount(),
            'coupon_amount'=>session()->has('coupon')?session()->get('coupon.amount'):0,
            'paying_amount'=>cartTotalAmount()
        ];
    }



}
