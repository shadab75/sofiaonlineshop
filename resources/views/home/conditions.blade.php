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
                    <li class="active">قوانین و مقررات </li>
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
                            <h2> قوانین و مقررات  <span> <a style="color: #418ed7" href="{{route('home.index')}}">صوفیا</a></span></h2>
                             <p  style="line-height: 45px;font-size: 18px;padding:20px;text-align: justify" >
                                استفاده شما از فروشگاه اینترنتی صوفیا و سفارش کالا از این پایگاه به معنی توافق کامل شما با شرایط و ضوابط ذیل تلقی می گردد:

                                <br>
                                اطلاعات و مشخصات کالاهای عرضه شده در فروشگاه اینترنتی صوفیا از منابع زیر تامین می‌شود:
                                <br>
                                1- اطلاعاتی که توسط نمایندگی های کالا ارائه می‌شوند.
                                <br>
                                2- اطلاعاتی که از سایت‌های معتبر خارجی ترجمه می‌شوند.
                                <br>
                                 3- اطلاعاتی که از روی خود محصول جمع آوری شده است .
                                 <br>
                                از این رو فروشگاه اینترنتی صوفیا هیچ مسئولیتی در قبال اطلاعات و محتوای مبهم و یا خطاهای نگارشی احتمالی برعهده نخواهد داشت. ولی با هدف ارائه خدمات بهتر و آگاه‌سازی مشتریان، خود را در بروزرسانی مداوم اطلاعات و محتویات متعهد می‌داند.
                                <br>
                                فروشگاه اینترنتی صوفیا هیچ گونه مسئولیتی را در مورد کارکرد سایت که می تواند ناشى از عواملی که خارج از سیطره مدیریت این فروشگاه می باشند (همانند نقص اینترنت، مسائل مخابراتى، تجهیزات سخت افزاری و غیره) نمی پذیرد.
                                <br>
                                فروشگاه اینترنتی صوفیا به هیچ وجه اطلاعات منحصر بفرد کاربران را به اشخاص و طرفین غیر، واگذار نخواهد کرد و ضمنا با استفاده از آخرین فن آوری ها متعهد است حتی المقدور از حریم شخصی کاربران دفاع کند.
                                 <br>
                                ارسال تمامی محصولات با استفاده از پست انجام میشود و متوسط زمان رسیدن کالا به دست مشتری بین 1 تا 6 روز کاری میباشد.

                            </p>
                         </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>






@endsection
