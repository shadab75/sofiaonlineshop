@extends('admin.layouts.admin')
@section('title')
    show orders
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white p-5">
            <div class="mb-4">
                <h5 class="font-weight-bold">سفارش : {{$order->id}}</h5>
            </div>
            <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام کاربر</label>
                        <input class="form-control" value="{{$order->user->name==null?'کاریر':$order->user->name}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>شماره تماس کاریر</label>
                        <input class="form-control" value="{{$order->user->cellphone}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>نام کوپن</label>
                        <input class="form-control" value="{{$order->coupon_id==null?'استفاده نشده':$order->coupon->name}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت</label>
                        <input class="form-control" value="{{$order->status}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>شماره سفارش</label>
                        <input class="form-control" value="{{$order->order_number}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>مبلغ</label>
                        <input class="form-control" value="{{number_format($order->total_amount)}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>هزینه ارسال</label>
                        <input class="form-control" value="{{$order->delivery_amount}}" disabled type="text">
                    </div>


                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input class="form-control" value="  {{verta($order->created_at)}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>مبلغ پرداختی</label>
                        <input class="form-control" value="{{number_format($order->paying_amount)}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>نوع پرداخت</label>
                        <input class="form-control" value="{{$order->payment_type}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت پرداخت</label>
                        <input class="form-control" value="{{$order->payment_status}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>شهر</label>
                        <input class="form-control" value="{{$order->city()->name}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>استان</label>
                        <input class="form-control" value="{{$order->province()->name}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>شماره تماس سفارش</label>
                        <input class="form-control" value="{{$order->address->cellphone}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>کد پستی</label>
                        <input class="form-control" value="{{$order->address->postal_code}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-12">
                        <label>آدرس</label>
                        <textarea class="form-control" disabled>{{$order->address->address}}</textarea>
                    </div>
                    <hr>
                    <h5>محصولات</h5>
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                        <tr>
                            <th> تصویر محصول</th>
                            <th> نام محصول</th>
                            <th> فی</th>
                            <th> تعداد</th>
                            <th> قیمت کل</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td class="product-thumbnail">
                                    <a href="{{route('admin.products.show',['product'=>$item->product->id])}}"><img width="100px" src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PAT').$item->product->primary_image)}}" alt=""></a>                                                 </td>
                                <td class="product-name"><a href="{{route('admin.products.show',['product'=>$item->product->id])}}"> {{$item->product->name}}
                                        <br>
                                        {{ App\Models\Attribute::query()->find($item->variation->first()->attribute_id)->name}}:
                                    {{$item->variation->value}}
                                    </a></td>

                                <td class="product-price-cart"><span class="amount">
                                                            {{number_format($item->price)}}
                                                            تومان
                                                        </span></td>
                                <td class="product-quantity">
                                    {{$item->quantity}}
                                </td>
                                <td class="product-subtotal">
                                    {{number_format($item->subtotal)}}
                                    تومان
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>


    </div>

@endsection
