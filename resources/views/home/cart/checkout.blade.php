@extends('home.layouts.home')

@section('title')
    صفحه سفارش
@endsection
@section('script')

    <script>
        $('#address-input').val($('#address-select').val())
        $('#address-select').change(function (){
            $('#address-input').val($(this).val())
        });
        $('.province_select').change(function (){
            var ProvinceID = $(this).val();
            if (ProvinceID){
                $.ajax({
                    type:"GET",
                    url:"{{url('/get-province-cities-list')}}?province_id="+ProvinceID,
                    success:function (res){
                        if (res){
                            $(".city_select").empty();
                            console.log(res)
                            $.each(res,function (key,city){
                                console.log(city)
                                $('.city_select').append('<option value="'+city.id+'">'+city.name+'</option>');
                            });
                        }else{
                            $('.city_select').empty();
                        }
                    }
                });
            }else{
                $('.city_select').empty();
            }
        })
    </script>
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}"> صفحه اصلی </a>
                    </li>
                    <li class="active"> سفارش</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="cart-main-area pt-95 pb-100 text-right" style="direction: rtl;">
        @if(\Cart::isEmpty())
            <div class="container cart-empty-content">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <i class="sli sli-basket"></i>
                        <h2 class="font-weight-bold my-4">سبد خرید خالی است.</h2>
                        <p class="mb-40">شما هیچ کالایی در سبد خرید خود ندارید.</p>
                        <a href="{{route('home.index')}}"> ادامه خرید </a>
                    </div>
                </div>
            </div>
        @else
            <div class="checkout-main-area pt-70 pb-70 text-right" style="direction: rtl;">

                <div class="container">

                    @if(!session()->has('coupon'))

                        <div class="customer-zone mb-20">
                            <p class="cart-page-title">
                                کد تخفیف دارید؟
                                <a class="checkout-click3" href="#"> میتوانید با کلیک در این قسمت کد خود را اعمال
                                    کنید </a>
                            </p>
                            <div class="checkout-login-info3">
                                <form action="{{route('home.coupons.check')}}" method="post">
                                    @csrf
                                    <input type="text" required placeholder="کد تخفیف" name="code">
                                    <input type="submit" value="اعمال کد تخفیف">
                                </form>
                            </div>
                        </div>

                    @endif

                    <div class="checkout-wrap pt-30">
                        <div class="row">

                            <div class="col-lg-7">
                                <div class="billing-info-wrap mr-50">
                                    <h3> آدرس تحویل سفارش </h3>

                                    <div class="row">
                                        <p style="font-size: 18px;line-height: 40px;font-weight: bold" class="p-2">
                                        لطفا قبل از تکمیل سفارش خود از به روز بودن اطلاعات در
                                            <a style="color: #1a9aef" href="{{route('home.users_profile.index')}}">پروفایل </a>
                                            خود اطمینان حاصل فرمایید.
                                        </p>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info tax-select mb-20">
                                                <label> انتخاب آدرس تحویل سفارش <abbr class="required"
                                                                                      title="required">*</abbr></label>
                                                <select class="email s-email s-wid" id="address-select" >

                                                    @foreach($addresses as $address)
                                                        <option value="{{$address->id}}"> {{$address->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 pt-30">
                                            <button class="collapse-address-create" style="border-radius: 5px" type="submit"> ایجاد آدرس جدید
                                            </button>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="collapse-address-create-content" style="{{count($errors->addressStore)>0?'display:block':''}}">

                                                <form action="{{route('home.address.store')}}" method="post">
                                                    @csrf
                                                    <div class="row">

                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                عنوان
                                                            </label>
                                                            <input type="text" name="title" value="{{old('title')}}">
                                                            @error('title','addressStore')
                                                            <p class="input-error-validation">
                                                                <strong>{{$message}}</strong>
                                                            </p>
                                                            @enderror
                                                        </div>
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                شماره تماس
                                                            </label>
                                                            <input type="text" name="cellphone" value="{{\App\Models\User::query()->where('id','=',auth()->id())->first()->cellphone}}">
                                                            @error('cellphone','addressStore')
                                                            <p class="input-error-validation">
                                                                <strong>{{$message}}</strong>
                                                            </p>
                                                            @enderror
                                                        </div>
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                استان
                                                            </label>
                                                            <select class="email s-email s-wid province_select" name="province_id">
                                                                @foreach($provinces as $province)
                                                                    <option value="{{$province->id}}">{{$province->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('province_id','addressStore')
                                                            <p class="input-error-validation">
                                                                <strong>{{$message}}</strong>
                                                            </p>
                                                            @enderror

                                                        </div>
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                شهر
                                                            </label>
                                                            <select class="email s-email s-wid city_select" name="city_id">
                                                            </select>

                                                            @error('city_id','addressStore')
                                                            <p class="input-error-validation">
                                                                <strong>{{$message}}</strong>
                                                            </p>
                                                            @enderror
                                                        </div>
                                                        <div class="tax-select col-lg-12 col-md-12">
                                                            <label>
                                                                 آدرس (خیابان ، پلاک ، واحد)
                                                            </label>
                                                            <textarea class="form-control" name="address" id="address">{{old('address')}}</textarea>
                                                            @error('address','addressStore')
                                                            <p class="input-error-validation">
                                                                <strong>{{$message}}</strong>
                                                            </p>
                                                            @enderror
                                                        </div>
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                کد پستی
                                                            </label>
                                                            <input type="text" name="postal_code" value="{{old('postal_code')}}">
                                                            @error('postal_code','addressStore')
                                                            <p class="input-error-validation">
                                                                <strong>{{$message}}</strong>
                                                            </p>
                                                            @enderror
                                                        </div>

                                                        <div class=" col-lg-12 col-md-12">

                                                            <button style="border-radius: 5px" class="cart-btn-2" type="submit"> ثبت آدرس
                                                            </button>
                                                        </div>



                                                    </div>

                                                </form>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-5">
                                <form action="{{route('home.payment')}}" method="post">
                                    @csrf
                                    <div class="your-order-area">
                                        <h3> سفارش شما </h3>
                                        <div class="your-order-wrap gray-bg-4">
                                            <div class="your-order-info-wrap">
                                                <div class="your-order-info">
                                                    <ul>
                                                        <li> محصول <span> جمع </span></li>
                                                    </ul>
                                                </div>
                                                <div class="your-order-middle">
                                                    <ul>
                                                        @foreach(\Cart::getContent() as $item)
                                                            <li class="d-flex justify-content-between">
                                                                <div>
                                                                    {{$item->name}}
                                                                    -
                                                                    تعداد :
                                                                    {{$item->quantity}}
                                                                    <p class="mb-0" style="font-size: 12px;color: #4875e1">
                                                                        {{\App\Models\Attribute::query()->find($item->attributes->attribute_id)->name}}
                                                                        :
                                                                        {{$item->attributes->value}}
                                                                    </p>
                                                                </div>
                                                                <span>
                                                        {{number_format($item->price)}}
                                                        تومان
                                                          @if($item->attributes->is_sale)
                                                                        <p style="font-size: 12px;color: #4875e1">
                                                      {{$item->attributes->percent_sale}}%
                                                     تخفیف
                                                   </p>
                                                                    @endif
                                                    </span>
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                </div>

                                                <div class="your-order-info order-subtotal">
                                                    <ul>
                                                        <li> مبلغ
                                                            <span>
                                                       {{number_format(\Cart::getTotal()+cartTotalSaleAmount())}}
                                                        تومان
                                                    </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @if(cartTotalSaleAmount()>0)
                                                    <div class="your-order-info order-subtotal">
                                                        <ul>
                                                            <li>
                                                                مبلغ تخفیف کالاها :
                                                                <span style="color: #4875e1">
                                                       {{number_format(cartTotalSaleAmount())}}
                                                      تومان
                                                        </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                                @if(session()->has('coupon'))
                                                    <div class="your-order-info order-subtotal">
                                                        <ul>
                                                            <li>
                                                                مبلغ کد تخفیف :
                                                                <span style="color: #4875e1">
                                           {{number_format(session()->get('coupon.amount'))}}
                                            تومان
                                        </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                                <div class="your-order-info order-shipping">
                                                    <ul>
                                                        <li> هزینه ارسال
                                                            هزینه ارسال :
                                                            @if(cartTotalDeliveryAmount()==0)
                                                                <span style="color: #4875e1;font-weight: bold">
                                                رایگان
                                        </span>
                                                            @else
                                                                <span>
                                            {{number_format(cartTotalDeliveryAmount())}}
                                            تومان
                                        </span>

                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="your-order-info order-total">
                                                    <ul>
                                                        <li>جمع کل
                                                            <span>
                                                         {{number_format(cartTotalAmount())}}
                                                        تومان </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="payment-method">
                                                <div class="pay-top sin-payment">
                                                    <input id="zarinpal" class="input-radio" type="radio" value="zarinpal"
                                                           checked="checked" name="payment_method">
                                                    <label for="zarinpal"> درگاه پرداخت زرین پال </label>
                                                    <div class="payment-box payment_method_bacs">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="Place-order mt-40">
                                            <button style="border-radius: 5px" type="submit">ثبت سفارش</button>
                                        </div>
                                    </div>
                                    <input type="hidden" id="address-input" name="address_id">
                                </form>
                            </div>


                        </div>

                    </div>

                </div>

            </div>
        @endif


    </div>
@endsection
