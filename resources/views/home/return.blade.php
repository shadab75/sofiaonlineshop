@extends('home.layouts.home')

@section('title')
    صفحه درباره ما
@endsection
@section('script')
    <script>
        $('#main-footer').css("margin-top",400);
    </script>

@endsection
@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}">صفحه اصلی</a>
                    </li>
                    <li class="active">شرایط مرجوعی کالا </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="about-story-area pt-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <div class="story-details pl-50">
                        <div class="story-details-top">
                            <h2> شرایط مرجوعی کالا در  <span> <a style="color: #418ed7" href="{{route('home.index')}}">صوفیا</a></span></h2>
                            <p  style="line-height: 45px;padding-top:20px;text-align: justify" >
                           <ul class="p-3" style="list-style: square"> <span style="font-size: 20px;font-weight: bold">شرایط مرجوع کردن : </span>
                                <li class="mt-3">عدم تطابق مرسول ارسال شده با محصول سفارش داده شده.</li>
                                <li class="pb-3 mt-3"> پارگی ، زدگی ، خوردگی و نقص داشتن محصول ارسال شده و یا مغایرت داشتن سایز. </li>
                            </ul>
                            <br>

                            <ul class="p-3" style="list-style: square"> <span style="font-size: 20px;font-weight: bold">در صورت برخورد با چنین مشکلاتی : </span>
                                <li class="mt-3"> از استفاده یا تعمیر کالا جلوگیری نمایید و آن را به شکل اولیه حفظ نمایید.</li>
                                <li class="mt-3">در صورتی که محصول بوی عطر و یا بوی بد بدهد شامل مرجوعی نمیشود.</li>
                                <li class="mt-3">برچسب محصول اعم از بارکد یا مارک محصول را به هیچ عنوان از لباس جدا نکنید در غیر این صورت شامل مرجوعی نمیشود.</li>
                            </ul>
                            <br>
                            <br>

                            <span style="color: red;font-size: 16px;font-weight: bold">بازگشت محصول در این شرایط کاملا رايگان خواهد بود و هزينه‌اي بابت آن از مشتري دريافت نخواهد شد.</span>
                            </p>
                            <br>

                            <ul class="p-3" style="list-style: square"><span style="font-size: 20px;font-weight: bold">نکات قابل توجه :  </span>
                             <li class="mt-3"> به استناد گزارشات سامانه اداره پست مربوط به مرسوله شما برگشت بسته های مرجوعی توسط شما فقط باید از طریق اداره پست انجام شود . </li>
                            <li  class="mt-3">فرصت ارسال مرجوعی توسط شما فقط یک روز بعد از تحویل بسته پستی به شما میباشد دارد پس از این مدت به هیج وجه قابل مرجوعی نمی باشد.</li>
                            <li  class="mt-3">از ارسال کالا بدون هماهنگی با واحد فروش آنلاین جداً خودداری نمایید.</li>
                            <li  class="mt-3">کالا هایی که دارای شرایط بهداشتی میباشد مانند لباس های راحتی شامل انواع ، بادی، نیم تنه ، کراپ شلوارک یا شورکت شامل مرجوعی نمیشود.</li>
                            <li  class="mt-3">کالا های تخفیف دار امکان مرجوعی ندارند.</li>
                            <li  class="mt-3">مبلغ مرجوعی 48 تا 72 ساعت بعد از اینکه بسته ارسالی شما به دست ما رسید پرداخت خواهد شد .</li>

                            <li  class="mt-3">
                                شماره تلگرام جهت هماهنگی برای کالای مرجوعی  : 09226506880
                            </li>
                            </ul>
                        </div>
                        <hr>
                        <br>
                        <span style="color: #1a9aef">آدرس پستی جهت ارسال کالا مرجوعی : </span>
                        <br>
                        <br>
                        <div >
                        <span>
                            تهران - بزرگراه شهید ستاری شمال - نبش خیابان پیامبر مرکزی - پاساژ کوروش - طبقه منفی ۱ - پلاک ۱۶۳
                        </span>
                        <br>
                        <br>
                        <span>
                            کد پستی : 1473611917
                        </span>
                        <br>
                        <br>
                        <span>
                            شماره تماس : 02144972125
                        </span>

                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>






@endsection
