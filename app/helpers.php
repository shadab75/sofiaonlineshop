<?php

use App\Models\City;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Province;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

if (!function_exists('generateFileName')){
    function generateFileName($name)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $hour = Carbon::now()->hour+1;
        $minute=Carbon::now()->minute;
        $second=Carbon::now()->second;
        $microSecond=Carbon::now()->microsecond;
        return $year.'_'.$month.'_'.$day.'_'.$hour.'_'.$minute.'_'.$second.'_'.$microSecond.'_'.$name;

    }
}


if (!function_exists('convertShamsiToGregorianDate')){
    function convertShamsiToGregorianDate($date){
        if ($date==null){
            return null;
        }
        $pattern = "/[-\s]/";
        $shamsiDateSplit=preg_split($pattern,$date);
        $ArrayGregorianDate = Verta::jalaliToGregorian($shamsiDateSplit[0],$shamsiDateSplit[1],$shamsiDateSplit[2]);
        return implode("-",$ArrayGregorianDate)." ".$shamsiDateSplit[3];
    }
}
if (!function_exists('cartTotalSaleAmount')){
    function cartTotalSaleAmount()
    {
        $cartTotalAmount = 0 ;
        foreach (\Cart::getContent() as $item){
            if ($item->attributes->is_sale){
                $cartTotalAmount += $item->quantity*($item->attributes->price-$item->attributes->sale_price);

            }
        }
        return $cartTotalAmount;
    }
}

if (!function_exists('cartTotalDeliveryAmount')){
    function cartTotalDeliveryAmount()
    {
        $cartTotalDeliveryAmount = 0 ;
        foreach (\Cart::getContent() as $item){

            $cartTotalDeliveryAmount   = $item->associatedModel->delivery_amount;
        }
        return $cartTotalDeliveryAmount;
    }
}

if (!function_exists('cartTotalAmount')){
    function cartTotalAmount(){
        if (session()->has('coupon')){
            if (session()->get('coupon.amount') > (\Cart::getTotal()+cartTotalDeliveryAmount()))
            {
                return 0;
            }else{
                return (\Cart::getTotal()+cartTotalDeliveryAmount())-session()->get('coupon.amount');
            }

        }else{
            return \Cart::getTotal()+cartTotalDeliveryAmount();
        }

    }
}


if (!function_exists('checkCoupon')){
    function checkCoupon ($code)
    {

        $coupon = Coupon::query()->where('code','=',$code)->where('expired_at','>',Carbon::now())->first();
        if ($coupon==null){
            session()->forget('coupon');
            return ['error'=>'کد تخفیف وارد شده وجود ندارد'];

        }
        if (Order::query()->where('user_id','=',auth()->id())
            ->where('coupon_id','=',$coupon->id)->where('payment_status','=',1)->exists()){
            session()->forget('coupon');
            return ['error'=>'شما قبلا از کد تخفیف استفاده کرده اید'];
        }
        if ($coupon->getRawOriginal('type')=='amount')
        {
            session()->put('coupon',['id'=>$coupon->id,'amount'=>$coupon->amount,'code'=>$coupon->code,'amount'=>$coupon->amount]);
        }else{
            $total = \Cart::getTotal();
            $amount = (($total*$coupon->percentage)/100) > $coupon->max_percentage_amount ? $coupon->max_percentage_amount : (($total*$coupon->percentage)/100);
            session()->put('coupon',['id'=>$coupon->id,'code'=>$coupon->code,'amount'=>$amount]);
        }
        return ['success'=>'کد تخفیف برای شما ثبت شد'];

    }
}
if (!function_exists('province_name')){
    function province_name($provinceId)
    {
        return Province::query()->findOrFail($provinceId)->name;
    }
}

if (!function_exists('city_name')){
    function city_name($cityId)
    {
        return City::query()->findOrFail($cityId)->name;
    }

}

