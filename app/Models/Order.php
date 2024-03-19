<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $guarded=[];

    public function getStatusAttribute($status)
    {
       switch ($status){
           case '0';
             $status='در انتظار پرداخت';
             break;
           case '1';
             $status = 'پرداخت شده';
             break;
       }
       return $status;
    }
    public function getPaymentTypeAttribute($payment_type)
    {
        switch ($payment_type){
            case 'online';
                $payment_type='اینترنتی';
                break;
            case 'pos';
                $payment_type = 'دستگاه POS';
                break;
        }
        return $payment_type;
    }
    public function getPaymentStatusAttribute($paymentStatus)
    {
        switch ($paymentStatus){
            case '0';
                $paymentStatus='ناموفق';
                break;
            case '1';
                $paymentStatus = 'موفق';
                break;
        }
        return $paymentStatus;
    }
    public function orderItems()
    {
        return $this->hasMany(orderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function city()
    {
        return City::query()->where('id','=',$this->address->city_id)->first();
    }

    public function  province()
    {
        return Province::query()->where('id','=',$this->address->province_id)->first();

    }
}
