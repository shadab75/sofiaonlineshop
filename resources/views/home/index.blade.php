@extends('home.layouts.home')

@section('title')
    صفحه اصلی
@endsection

@section('script')
@endsection
@section('content')
    <div class="slider-area section-padding-1">
        <div class="slider-active owl-carousel nav-style-1">
            @foreach ($sliders as $slider)
                <div class="single-slider slider-height-1 bg-gray">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6 text-right">
                                <div class="slider-content slider-animated-1">
                                    <h1 class="animated">
                                        {{ $slider->title }}
                                    </h1>
                                    <p class="animated">
                                        {{ $slider->text }}
                                    </p>
                                    <div class="slider-btn btn-hover">
                                        <a class="animated" href="{{ $slider->button_link }}">
                                            <i class="{{ $slider->button_icon }}"></i>
                                            {{ $slider->button_text }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6">
                                <div class="slider-single-img slider-animated-1">
                                    <img class="animated"
                                         src="{{ asset(env('BANNER_IMAGES_UPLOAD_PAT') . $slider->image) }}"
                                         alt="{{ $slider->alt}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="banner-area pt-100 pb-65">
        <div class="container">
            <div class="row">

                @foreach ($indexTopBanners->chunk(3)->first() as $banner)
                    <div class="col-lg-4 col-md-4">
                        <div class="single-banner mb-30 scroll-zoom">

                            <a href="{{$banner->button_link }}">
                                <img class="animated"
                                     src="{{ asset(env('BANNER_IMAGES_UPLOAD_PAT') . $banner->image) }}"
                                     alt="{{$banner->alt}}"/>
                            </a>
                            <div class="banner-content-2 banner-position-5">
                                <h4>{{ $banner->title }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($indexTopBanners->chunk(3)->last() as $banner)
                    <div class="col-lg-6 col-md-6">
                        <div class="single-banner mb-30 scroll-zoom">
                            <a href="{{$banner->button_link }}">
                                <img class="animated"
                               src="{{ asset(env('BANNER_IMAGES_UPLOAD_PAT') . $banner->image) }}"
                               alt="{{$banner->alt}}"/></a>
                            <div
                                class="{{ $loop->last ? 'banner-content-3 banner-position-7' : 'banner-content banner-position-6 text-right' }}">
                                <h3>{{ $banner->title }}</h3>
                                <a href="{{ $banner->button_link }}">{{ $banner->button_text}}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="product-area pb-70">
        <div class="container">
            <div class="section-title text-center pb-40">
                <h2>دسته بندی محصولات </h2>
             <p dir="rtl" style="text-align: center">
                 <b><a href="{{route('home.index')}}">صوفیا</a></b> یک فروشگاه لباس زنانه است که به عنوان یک مقصد مد برای خریداران علاقه ‌مند به طراحی های جدید و باکیفیت شناخته میشود. این فروشگاه با ارائه مجموعه‌ای گسترده از لباس‌ های زنانه، از روزمره تا مجلسی، به انواع سلیقه ‌ها و نیازهای مختلف مشتریان پاسخ میدهد.
                 در <b><a href="{{route('home.index')}}">صوفیا</a></b>، مشتریان میتوانند مجموعه ای از لباس های منحصر به فرد و با طراحی های جذاب و متنوع انتخاب کنند. <b><a
                         href="{{route('home.index')}}">صوفیا</a></b> نیز برای رفاه حال مشتریان، انواع لباس ها با سایز ها و اندازه های مختلف را در اختیار آن ها قرار میدهد.
             </p>
            </div>
            <div class="product-tab-list nav pb-60 text-center flex-row-reverse">
                @php
                    $chileCategory = App\Models\Category::query()
                    ->where('parent_id' ,'!=',0)
                    ->where('is_active',1)
                    ->get();
                @endphp

               @foreach($chileCategory as $category)
                     @if($category->parent->is_active=='فعال')
                    <a href="{{route('home.categories.show',['category'=>$category->slug])}}">
                        <h4>{{$category->name}}</h4>
                    </a>
                    @endif
               @endforeach
            </div>
            <div class="tab-content jump-2">

                <div id="#" class="tab-pane active">
                    <div class="ht-products product-slider-active owl-carousel owl-animated-in">
                        <!--Product Start-->

                        @foreach ($products as $product)

                            <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                <div class="ht-product-inner">
                                    <div class="ht-product-image-wrap">
                                        <a href="{{route('home.products.show',['product'=>$product->slug])}}" class="ht-product-image">
                                            <img
                                                 src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}"
                                                 alt="{{ $product->name }}"/>
                                        </a>

                                        <div class="ht-product-action">
                                            <ul>
                                                <li>
                                                    <a href="#" data-toggle="modal"
                                                       data-target="#productModal-{{$product->id}}"><i
                                                            class="showDetail sli sli-magnifier"></i><span
                                                            class=" ht-product-action-tooltip"> مشاهده سریع
                                                    </span></a>
                                                </li>
                                                <li>
                                                    @auth
                                                         @if($product->checkUserWishlist(auth()->id()))
                                                            <a href="{{route('home.wishlist.remove',['product'=>$product->id])}}"><i
                                                                    class="fas fa-heart" style="color: red"></i>
                                                                <span
                                                                    class="ht-product-action-tooltip">
                                                            به لیست علاقه مندی ها اضافه شده است
                                                        </span>
                                                            </a>
                                                         @else
                                                            <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i class="sli sli-heart"></i>
                                                                <span
                                                                    class="ht-product-action-tooltip">
                                                            افزودن به علاقه مندی ها
                                                        </span>
                                                            </a>

                                                         @endif

                                                    @else
                                                        <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i class="sli sli-heart"></i>
                                                            <span
                                                                class="ht-product-action-tooltip">
                                                            افزودن به علاقه مندی ها
                                                        </span>
                                                        </a>
                                                    @endauth

                                                </li>
                                                <li>
                                                    <a href="{{route('home.compare.add',['product'=>$product])}}"><i class="sli sli-refresh"></i><span
                                                            class="ht-product-action-tooltip"> مقایسه
                                                    </span></a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="ht-product-content">
                                        <div class="ht-product-content-inner">
                                            <div class="ht-product-categories">
                                                <a href="{{route('home.categories.show',['category'=>$product->category->slug])}}">{{ $product->category->name }}</a>
                                            </div>
                                            <h4 class="ht-product-title text-right">
                                                <a href="#"> {{ $product->name }} </a>
                                            </h4>
                                            <div class="ht-product-price">
                                                @if($product->quantity_check)
                                                    @if($product->sale_check)
                                                        <span class="new" style="font-size: 16px!important;">
                                                        {{ number_format($product->sale_check->sale_price) }}
                                                        تومان
                                                    </span>
                                                        <span class="old">
                                                        {{ number_format($product->sale_check->price) }}
                                                        تومان
                                                    </span>
                                                    @else
                                                        <span class="new">
                                                        {{ number_format($product->price_check->price) }}
                                                        تومان
                                                    </span>
                                                    @endif
                                                @else
                                                    <div class="not-in-stock">
                                                        <p class="text-white">ناموجود</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ht-product-ratting-wrap mt-4">
                                                <div data-rating-stars="5"
                                                     data-rating-readonly="true"
                                                     data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{route('home.products.show',['product'=>$product->slug])}}" style="background-color: #418ed7;color: white" class="btn btn-primary">مشاهده جزییات محصول</a>
                                    </div>
                                 </div>

                            </div>
                        @endforeach
                        <!--Product End-->
                    </div>
                </div>
                <div class="product-area pb-70">
                    <div class="container">
                        <div class="section-title text-center pt-3 pb-40">
                            <h5 id="myH3"><span  class="line-center">جدید ترین محصولات</span></h5>

                        </div>
                        <div class="text-right mb-3">
                            <a href="{{route('home.latest-products')}}" class="btn btn-primary" style="background-color: #418ed7!important;">مشاهده همه</a>
                        </div>

                        <div class="tab-content jump-2">
                            <div id="#" class="tab-pane active">
                                <div class="ht-products product-slider-active owl-carousel owl-animated-in">
                                    <!--Product Start-->

                                    @foreach ($bestSailingProducts as $bestSailingProduct )
                                        <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                            <div class="ht-product-inner">
                                                <div class="ht-product-image-wrap">
                                                    <a href="{{route('home.products.show',['product'=>$bestSailingProduct->slug])}}" class="ht-product-image">
                                                        <img
                                                            src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $bestSailingProduct->primary_image) }}"
                                                            alt="{{ $bestSailingProduct->name }}"/>
                                                    </a>
                                                    <div class="ht-product-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" data-toggle="modal"
                                                                   data-target="#productModal-{{$bestSailingProduct->id}}"><i
                                                                        class="showDetail sli sli-magnifier"></i><span
                                                                        class=" ht-product-action-tooltip"> مشاهده سریع
                                                    </span></a>
                                                            </li>
                                                            <li>
                                                                @auth
                                                                    @if($bestSailingProduct->checkUserWishlist(auth()->id()))
                                                                        <a href="{{route('home.wishlist.remove',['product'=>$bestSailingProduct->id])}}"><i
                                                                                class="fas fa-heart" style="color: red"></i>
                                                                            <span
                                                                                class="ht-product-action-tooltip">
                                                            به لیست علاقه مندی ها اضافه شده است
                                                        </span>
                                                                        </a>
                                                                    @else
                                                                        <a href="{{route('home.wishlist.add',['product'=>$bestSailingProduct->id])}}"><i class="sli sli-heart"></i>
                                                                            <span
                                                                                class="ht-product-action-tooltip">
                                                            افزودن به علاقه مندی ها
                                                        </span>
                                                                        </a>

                                                                    @endif

                                                                @else
                                                                    <a href="{{route('home.wishlist.add',['product'=>$bestSailingProduct->id])}}"><i class="sli sli-heart"></i>
                                                                        <span
                                                                            class="ht-product-action-tooltip">
                                                            افزودن به علاقه مندی ها
                                                        </span>
                                                                    </a>
                                                                @endauth

                                                            </li>
                                                            <li>
                                                                <a href="{{route('home.compare.add',['product'=>$bestSailingProduct])}}"><i class="sli sli-refresh"></i><span
                                                                        class="ht-product-action-tooltip"> مقایسه
                                                    </span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="ht-product-content">
                                                    <div class="ht-product-content-inner">
                                                        <div class="ht-product-categories">
                                                            <a href="{{route('home.categories.show',['category'=>$bestSailingProduct->category->slug])}}">{{ $bestSailingProduct->category->name }}</a>
                                                        </div>
                                                        <h4 class="ht-product-title text-right">
                                                            <a href="#"> {{ $bestSailingProduct->name }} </a>
                                                        </h4>
                                                        <div class="ht-product-price">
                                                            @if($bestSailingProduct->quantity_check)
                                                                @if($bestSailingProduct->sale_check)
                                                                    <span class="new" style="font-size: 16px!important;">
                                                        {{ number_format($bestSailingProduct->sale_check->sale_price) }}
                                                        تومان
                                                    </span>
                                                                    <span class="old">
                                                        {{ number_format($bestSailingProduct->sale_check->price) }}
                                                        تومان
                                                    </span>
                                                                @else
                                                                    <span class="new">
                                                        {{ number_format($bestSailingProduct->price_check->price) }}
                                                        تومان
                                                    </span>
                                                                @endif
                                                            @else
                                                                <div class="not-in-stock">
                                                                    <p class="text-white">ناموجود</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ht-product-ratting-wrap mt-4">
                                                            <div data-rating-stars="5"
                                                                 data-rating-readonly="true"
                                                                 data-rating-value="{{ ceil($bestSailingProduct->rates->avg('rate')) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="text-center">
                                                    <a href="{{route('home.products.show',['product'=>$bestSailingProduct->slug])}}" style="background-color: #418ed7;color: white" class="btn btn-primary">مشاهده جزییات محصول</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!--Product End-->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="product-area pb-70">
                    <div class="container">
                        <div class="section-title text-center pt-3 pb-40">
                            <h5 id="myH3"><span  class="line-center">پیشنهادات ویژه</span></h5>

                        </div>
                        <div class="text-right mb-3">
                            <a href="{{route('home.discounted-products')}}" class="btn btn-primary" style="background-color: #418ed7">مشاهده همه</a>
                        </div>

                        <div class="tab-content jump-2">
                            <div id="#" class="tab-pane active">
                                <div class="ht-products product-slider-active owl-carousel owl-animated-in">
                                    <!--Product Start-->
                                    <?php
                                        $is_sale_products = \App\Models\Product::all();

                                     ?>
                                    @foreach ( $is_sale_products as $product)
                                          @if($product->sale_check)
                                        <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                            <div class="ht-product-inner">
                                                <div class="ht-product-image-wrap">
                                                    <a href="{{route('home.products.show',['product'=>$product->slug])}}" class="ht-product-image">
                                                        <img
                                                            src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}"
                                                            alt="{{ $product->name }}"/>
                                                    </a>

                                                    <div class="ht-product-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" data-toggle="modal"
                                                                   data-target="#productModal-{{$product->id}}"><i
                                                                        class="showDetail sli sli-magnifier"></i><span
                                                                        class=" ht-product-action-tooltip"> مشاهده سریع
                                                    </span></a>
                                                            </li>
                                                            <li>
                                                                @auth
                                                                    @if($product->checkUserWishlist(auth()->id()))
                                                                        <a href="{{route('home.wishlist.remove',['product'=>$product->id])}}"><i
                                                                                class="fas fa-heart" style="color: red"></i>
                                                                            <span
                                                                                class="ht-product-action-tooltip">
                                                            به لیست علاقه مندی ها اضافه شده است
                                                        </span>
                                                                        </a>
                                                                    @else
                                                                        <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i class="sli sli-heart"></i>
                                                                            <span
                                                                                class="ht-product-action-tooltip">
                                                            افزودن به علاقه مندی ها
                                                        </span>
                                                                        </a>

                                                                    @endif

                                                                @else
                                                                    <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i class="sli sli-heart"></i>
                                                                        <span
                                                                            class="ht-product-action-tooltip">
                                                            افزودن به علاقه مندی ها
                                                        </span>
                                                                    </a>
                                                                @endauth

                                                            </li>
                                                            <li>
                                                                <a href="{{route('home.compare.add',['product'=>$product])}}"><i class="sli sli-refresh"></i><span
                                                                        class="ht-product-action-tooltip"> مقایسه
                                                    </span></a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>
                                                <div class="ht-product-content">
                                                    <div class="ht-product-content-inner">
                                                        <div class="ht-product-categories">
                                                            <a href="{{route('home.categories.show',['category'=>$product->category->slug])}}">{{ $product->category->name }}</a>
                                                        </div>
                                                        <h4 class="ht-product-title text-right">
                                                            <a href="#"> {{ $product->name }} </a>
                                                        </h4>
                                                        <div class="ht-product-price">
                                                            @if($product->quantity_check)
                                                                @if($product->sale_check)
                                                                    <span class="new" style="font-size: 16px!important;">
                                                        {{ number_format($product->sale_check->sale_price) }}
                                                        تومان
                                                    </span>
                                                                    <span class="old">
                                                        {{ number_format($product->sale_check->price) }}
                                                        تومان
                                                    </span>
                                                                @else
                                                                    <span class="new">
                                                        {{ number_format($product->price_check->price) }}
                                                        تومان
                                                    </span>
                                                                @endif
                                                            @else
                                                                <div class="not-in-stock">
                                                                    <p class="text-white">ناموجود</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ht-product-ratting-wrap mt-4">
                                                            <div data-rating-stars="5"
                                                                 data-rating-readonly="true"
                                                                 data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <a href="{{route('home.products.show',['product'=>$product->slug])}}" style="background-color: #418ed7;color: white" class="btn btn-primary">مشاهده جزییات محصول</a>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                    @endforeach

                                        <!--Product End-->
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="container">
    <div class="section-title text-center pt-3 pb-40">
        <h5 id="myH3"><span  class="line-center">مقالات</span></h5>
    </div>
    <div class="text-right mb-3">
        <a href="{{route('home.blogs.index')}}" class="btn btn-primary" style="background-color: #418ed7!important;">مشاهده همه</a>
    </div>
</div>
  <div class="container text-right d-flex flex-wrap justify-content-center" style="max-width: 1200px;margin-block: 2rem;gap: 2rem">
@foreach($blogs as $blog)
      <div class="card">
          <div class="card__header">
              <a href="{{route('home.blogs.show',['blog'=>$blog->slug])}}">
              <img style="max-width: 100%;display: block "
                  src="{{ asset(env('BLOG_IMAGES_UPLOAD_PAT') . $blog->image) }}" alt="{{$blog->title}}" class="card__image" width="600">
              </a>
          </div>
          <div class="card__body" dir="rtl">
              <span class="tag align-self-end tag-blue" >صوفیا</span>
              <h5>{{$blog->title}}</h5>

          </div>

          <div class="card__footer" dir="rtl">
              <div class="user">
                   <div class="user__info text-right">
                      <h5>{{$blog->author}}</h5>
                      <small>{{verta($blog->created_at)->formatWord('d F Y')}}</small>
                  </div>
              </div>
          </div>
      </div>
      @endforeach

  </div>


    <div class="banner-area pt-80 pb-120">
        <div class="container">
            <div class="row">
                @foreach ($indexBottomBanners as $banner)
                    <div class="col-lg-6 col-md-6 text-right">
                        <div class="single-banner mb-30 scroll-zoom">
                            <a href="{{$banner->button_link }}"><img
                                    src="{{ asset(env('BANNER_IMAGES_UPLOAD_PAT') . $banner->image) }}" alt="{{$banner->alt}}"/></a>
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

    <div class="feature-area" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="single-feature text-right mb-40">
                        <div class="feature-icon">
                            <img src="{{ asset('images/home/free-shipping.png') }}" alt="features"/>
                        </div>
                        <div class="feature-content">
                            <h4>ارسال به سراسر کشور</h4>
                            <p>به تمام نقاط ایران ارسال داریم</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="single-feature text-right mb-40 pl-50">
                        <div class="feature-icon">
                            <img src="{{ asset('images/home/support.png') }}" alt="features"/>
                        </div>
                        <div class="feature-content">
                            <h4>پشتیبانی سریع</h4>
                            <p>آماده پاسخگویی 24 ساعته </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="single-feature text-right mb-40">
                        <div class="feature-icon">
                            <img src="{{ asset('images/home/security.png') }}" alt="features"/>
                        </div>
                        <div class="feature-content">
                            <h4>بهترین کیفیت</h4>
                            <p>همه اجناس دارای بهترین کیفیت میباشند</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @foreach ($products as $product)
        <div class="modal fade" id="productModal-{{$product->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                                <div class="product-details-content quickview-content">
                                    <h2 class="text-right mb-4">{{ $product->name }}</h2>



                                    <p class="text-right">
                                        {!! html_entity_decode($product->description) !!}
                                    </p>
                                    <div class="pro-details-list text-right">
                                        <ul class="text-right">
                                            @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                                                <li> -
                                                    {{ $attribute->attribute->name }}
                                                    :
                                                    {{ $attribute->value }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>




                                    <div class="pro-details-meta">
                                        <span>دسته بندی :</span>
                                        @if($product->category->parent_id==0)
                                            <ul>
                                                <li><a href="{{route('home.categories.show',['category'=>$product->category->slug])}}">{{ $product->category->name }}</a></li>
                                            </ul>
                                        @else
                                            <ul>
                                                <li><a href="{{route('home.categories.show',['category'=>$product->category->slug])}}">{{$product->category->parent->name}}
                                                        ,{{ $product->category->name }}</a></li>
                                            </ul>
                                        @endif

                                    </div>
                                    <div class="pro-details-meta">
                                        <span>تگ ها :</span>
                                        <ul>
                                            @foreach ($product->tags as $tag)
                                                <li><a href="{{route('tags.show',['tag'=>$tag->name])}}">{{ $tag->name }}{{ $loop->last ? '' : '،' }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="tab-content quickview-big-img">
                                    <div id="pro-primary-{{$product->id}}" class="tab-pane fade show active">
                                        <img
                                            src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}"
                                            alt="{{$product->name}}"/>
                                    </div>
                                    @foreach ($product->images as $image)
                                        <div id="pro-{{$image->id}}" class="tab-pane fade">
                                            <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $image->image) }}"
                                                 alt="{{$product->name}}"/>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Thumbnail Large Image End -->
                                <!-- Thumbnail Image End -->
                                <div class="quickview-wrap mt-15">
                                    <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                        <a class="active" data-toggle="tab" href="#pro-primary-{{$product->id}}">
                                            <img
                                                src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}"
                                                alt="{{$product->name}}"/>
                                        </a>
                                        @foreach ($product->images as $image)
                                            <a data-toggle="tab" href="#pro-{{$image->id}}">
                                                <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $image->image) }}"
                                                     alt="{{$product->name}}"/>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach ($bestSailingProducts as $bestSailingProduct)
        <div class="modal fade" id="productModal-{{$bestSailingProduct->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                                <div class="product-details-content quickview-content">
                                    <h2 class="text-right mb-4">{{ $bestSailingProduct->name }}</h2>


                                    <p class="text-right">
                                            {!! html_entity_decode($bestSailingProduct->description) !!}
                                    </p>
                                    <div class="pro-details-list text-right">
                                        <ul class="text-right">
                                            @foreach ($bestSailingProduct->attributes()->with('attribute')->get() as $attribute)
                                                <li> -
                                                    {{ $attribute->attribute->name }}
                                                    :
                                                    {{ $attribute->value }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>




                                    <div class="pro-details-meta">
                                        <span>دسته بندی :</span>
                                        @if($bestSailingProduct->category->parent_id==0)
                                            <ul>
                                                <li><a href="{{route('home.categories.show',['category'=>$bestSailingProduct->category->slug])}}">{{ $bestSailingProduct->category->name }}</a></li>
                                            </ul>
                                        @else
                                            <ul>
                                                <li><a href="#">{{$bestSailingProduct->category->parent->name}}
                                                        ,{{ $bestSailingProduct->category->name }}</a></li>
                                            </ul>
                                        @endif

                                    </div>
                                    <div class="pro-details-meta">
                                        <span>تگ ها :</span>
                                        <ul>
                                            @foreach ($bestSailingProduct->tags as $tag)
                                                <li><a href="{{route('tags.show',['tag'=>$tag->name])}}">{{ $tag->name }}{{ $loop->last ? '' : '،' }}</a></li>

                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="tab-content quickview-big-img">
                                    <div id="pro-primary-{{$bestSailingProduct->id}}" class="tab-pane fade show active">
                                        <img
                                            src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $bestSailingProduct->primary_image) }}"
                                            alt="{{$bestSailingProduct->name}}"/>
                                    </div>
                                    @foreach ($bestSailingProduct->images as $image)
                                        <div id="pro-{{$image->id}}" class="tab-pane fade">
                                            <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $bestSailingProduct->image) }}"
                                                 alt="{{$bestSailingProduct->name}}"/>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Thumbnail Large Image End -->
                                <!-- Thumbnail Image End -->
                                <div class="quickview-wrap mt-15">
                                    <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                        <a class="active" data-toggle="tab" href="#pro-primary-{{$bestSailingProduct->id}}">
                                            <img
                                                src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $bestSailingProduct->primary_image) }}"
                                                alt="{{$bestSailingProduct->name}}"/>
                                        </a>
                                        @foreach ($bestSailingProduct->images as $image)
                                            <a data-toggle="tab" href="#pro-{{$bestSailingProduct->id}}">
                                                <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $image->image) }}"
                                                     alt="{{$bestSailingProduct->name}}"/>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
