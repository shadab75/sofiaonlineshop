@extends('home.layouts.home')

@section('title')
    صفحه درباره ما
@endsection
@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}">صفحه اصلی</a>
                    </li>
                    <li class="active"> در باره ما </li>
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
                            <h2> خوش آمدید به  <span> <a style="color: #418ed7" href="{{route('home.index')}}">صوفیا</a></span></h2>
                            <p  style="line-height: 40px;font-size: 18px;text-align: justify">
                                <b><a href="{{route('home.index')}}">صوفیا</a></b>، فروشگاهی است که با هدف ارائه بهترین مجموعه از لباس ‌های زنانه و به ‌روز در سال 1402 در یکی از معتبر ترین مال های ایران ، کوروش مال تأسیس شده است. در <b><a
                                        href="{{route('home.index')}}">صوفیا</a></b>، به عنوان مشتری، شما شاهد یک تجربه خرید منحصر به فرد هستید. ما به دنبال آن هستیم که محصولاتی را ارائه دهیم که کیفیت بالایی را داشته باشند.

                                هدف ما در <a href="{{route('home.index')}}">صوفیا</a> این است که به شما کمک کنیم خود را با لباس‌ های خاص و جذاب نشان دهید. ما معتقدیم که پوشیدن لباس ‌های خوب و باکیفیت تأثیر بزرگی در اعتماد به نفس شما خواهد داشت بنابراین اهمیت زیادی به انتخاب و ارائه لباس ‌هایی که کیفیت و جنس بالایی را داشته باشند میدهیم.

                                در <b><a href="{{route('home.index')}}">صوفیا</a></b>، صداقت، احترام به مشتریان و خدمات عالی در اولویت قرار دارد. تیم ما همواره آماده است تا شما را در هر مرحله از خرید خود همراهی کند و به شما کمک کند تا تجربه لذت بخشی را داشته باشید.

                                با ما در این سفر به سمت مد زندگی کنید و خود را در دنیایی از شیکترین لباس‌ های زنانه به‌ روز کنید. به <b><a
                                        href="{{route('home.index')}}">صوفیا</a></b> بپیوندید و تجربه‌ای منحصر به فرد را پیدا کنید.
                             </p>
                        </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    <div class="banner-area">
        <div class="container">
            <div class="row">
                @foreach ($BottomBanners as $banner)
                    <div class="col-lg-6 col-md-6 text-right">
                        <div class="single-banner mb-30 scroll-zoom">
                            <img src="{{ asset(env('BANNER_IMAGES_UPLOAD_PAT') . $banner->image) }}" alt="درباره ما" height="400px"/>
                            <div class="banner-content {{ $loop->last ? 'banner-position-4' : 'banner-position-3' }}">
                                <h3>{{ $banner->title }}</h3>
                                <h2>{{ $banner->text }}</h2>
                                <a href="{{ $banner->button_link }}">{{ $banner->button_text }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>





@endsection
