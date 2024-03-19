<?php
namespace App\PaymentGateway;
use App\Models\Order;
use App\Models\orderItem;
use App\Models\ProductVariation;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\NewOrder;
use App\Notifications\PaymentReceipt;
use Illuminate\Support\Facades\DB;

class Payment
{
    function createOrder($addressId,$amounts,$token,$gateway_name)
    {

        $numbers = range(1, 100); // Generate an array of numbers from 1 to 100

        shuffle($numbers); // Randomize the order of the numbers

        $randomNumbers = array_slice($numbers, 0, 10); // Take the first 10 numbers from the shuffled array

        try {
            DB::beginTransaction();
            $order = Order::query()->create([
                'user_id'=>auth()->id(),
                'address_id'=>$addressId,
                'coupon_id'=>session()->has('coupon') ? session()->get('coupon.id') :null,
                'total_amount'=>$amounts['total_amounts'],
                'delivery_amount'=>$amounts['delivery_amount'],
                'coupon_amount'=>$amounts['coupon_amount'],
                'paying_amount'=>$amounts['paying_amount'],
                'payment_type'=>'online',
                'order_number'=>rand(10000, 99999)
            ]);
            foreach (\Cart::getContent() as $item){
                orderItem::query()->create([
                    'order_id'=>$order->id,
                    'product_id'=>$item->associatedModel->id,
                    'product_variation_id'=>$item->attributes->id,
                    'price'=>$item->price,
                    'quantity'=>$item->quantity,
                    'subtotal'=>($item->quantity*$item->price)


                ]);
            }
            Transaction::query()->create([
                'user_id'=>auth()->id(),
                'order_id'=>$order->id,
                'amount'=>$amounts['paying_amount'],
                'token'=>$token,
                'gateway_name'=>$gateway_name



            ]);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return ['error'=>$ex->getMessage()];
        }
        return ['success'=>'success!'];
    }
    function updateOrder($token,$refId)
    {

        try {
            DB::beginTransaction();
            $transaction = Transaction::query()->where('token','=',$token)->firstOrFail();
            $transaction->update([
                'status'=>1,
                'ref_id'=>$refId
            ]);
            $order = Order::query()->findOrFail($transaction->order_id);
            $order->update([
                'payment_status'=>1,
                'status'=>1
            ]);
            auth()->user()->notify(new PaymentReceipt($order->order_number,$order->paying_amount,$refId));
            $user = User::query()->where('cellphone','=','admincellphonenumber')->first();
            $user->notify(new NewOrder($order->order_number,$order->paying_amount));

            foreach (\Cart::getContent() as $item)
            {
                $variation = ProductVariation::query()->find($item->attributes->id);
                $variation->update([
                    'quantity'=>$variation->quantity - $item->quantity
                ]);
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return ['error' => $ex->getMessage()];
        }
        return ['success' => 'success!'];
    }

}
