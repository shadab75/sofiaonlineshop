@extends('home.layouts.home')

@section('title')
    صفحه فروشگاه
@endsection
@section('script')
    <script>
       let variation =JSON.parse( $('.variation-select').val());
       let product = @json($product);
       console.log(product)
          // $('.cart-plus-minus-box' ).attr('data-max', variation.quantity);

       $('.quantity-input-' + product.id).attr('data-max', variation.quantity);


        $('.variation-select').on('change', function () {
            let variation = JSON.parse(this.value);
            let variationPriceDiv = $('.variation-price-' + $(this).data('id'));

            variationPriceDiv.empty();

            if (variation.is_sale) {
                let spanSale = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.sale_price)) + ' تومان'
                });
                let spanPrice = $('<span />', {
                    class: 'old',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });

                variationPriceDiv.append(spanSale);
                variationPriceDiv.append(spanPrice);
            } else {
                let spanPrice = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });
                variationPriceDiv.append(spanPrice);
            }

            $('.quantity-input-' + $(this).data('id')).attr('data-max', variation.quantity);

            $('.quantity-input-' + $(this).data('id')).val(1);

        });
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
                    <li class="active">فروشگاه</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="product-details-area pt-100 pb-95">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 order-2 order-sm-2 order-md-1" style="direction: rtl;">
                    <div class="product-details-content ml-30">
                        <h2 class="text-right">{{$product->name}} </h2>
                        <div class="product-details-price variation-price-{{$product->id}}">
                            @if($product->quantity_check)
                                @if($product->sale_check)
                                    <span class="new">
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
                        <div class="pro-details-rating-wrap">
                            <div class="pro-details-rating-wrap">

                                <div data-rating-stars="5"
                                     data-rating-readonly="true"
                                     data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                </div>
                                <span class="mx-3">|</span>
                                <span>دیدگاه
                                  ({{$product->approvedComments()->count()}})
                                </span>
                            </div>
                        </div>
                        <div style="font-size: 20px;line-height: 40px!important;">
                            <p>
                                {!! html_entity_decode($product->description) !!}

                            </p>
                        </div>
                        <div style="font-size: 18px;line-height: 36px" class="pro-details-list text-right">
                            <ul>
                                @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                                    <li> -
                                        {{ $attribute->attribute->name }}
                                        :
                                        {{ $attribute->value }}
                                    </li>
                                @endforeach
                            </ul>
                            <div class="pt-3">
                                <div class="pt pro-details-meta">
                                    <span>دسته بندی :</span>
                                    @if($product->category->parent_id==0)
                                        <ul>
                                            <a href="{{route('home.categories.show',['category'=>$product->category->slug])}}">{{ $product->category->name }}</a>
                                        </ul>
                                    @else
                                        <ul>
                                            <li>
                                                <a href="{{route('home.categories.show',['category'=>$product->category->slug])}}">{{$product->category->parent->name}}
                                                    ,{{ $product->category->name }}</a></li>
                                        </ul>
                                    @endif

                                </div>
                                <div class="pro-details-meta">
                                    <span>تگ ها :</span>
                                    <ul>
                                        @foreach ($product->tags as $tag)
                                            <li>
                                                <a href="{{route('tags.show',['tag'=>$tag->name])}}">{{ $tag->name }}{{ $loop->last ? '' : '،' }}</a>
                                            </li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <form action="{{route('home.cart.add')}}" method="post">
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            @csrf
                            @if($product->quantity_check)
                                @php
                                    if($product->sale_check)
                                    {
                                        $variationProductSelected = $product->sale_check;
                                    }else{
                                        $variationProductSelected = $product->price_check;
                                    }
                                @endphp
                                <div class="pro-details-size-color text-right">
                                    <div class="pro-details-size w-50">
                                        <span>{{ App\Models\Attribute::query()->find($product->variations->first()->attribute_id)->name }}</span>
                                        <select class="form-control variation-select" name="variation"
                                                data-id="{{$product->id}}">

                                            @foreach ($product->variations()->where('quantity' , '>' , 0)->get() as $variation)
                                                <option
                                                    value="{{ json_encode($variation->only(['id' , 'quantity','is_sale' , 'sale_price' , 'price'])) }}"
                                                    {{ $variationProductSelected->id == $variation->id ? 'selected' : '' }}
                                                >{{ $variation->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="pro-details-quality">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box quantity-input-{{ $product->id }}" type="text"
                                               name="qtybutton" value="1"
                                               data-max="{{ $product->variations()->where('quantity' , '>' , 0)->first()->quantity }}"/>

                                    </div>
                                    <button type="submit" class="p-3 mr-1 btn btn-dark">افزودن به سبد خرید</button>
                                    <div class=" mr-2 pro-details-wishlist">
                                        @auth
                                            @if($product->checkUserWishlist(auth()->id()))
                                                <a href="{{route('home.wishlist.remove',['product'=>$product->id])}}"><i
                                                        class="fas fa-heart" style="color: red"></i>
                                                </a>
                                            @else
                                                <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i
                                                        class="sli sli-heart"></i>

                                                </a>

                                            @endif

                                        @else
                                            <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i
                                                    class="sli sli-heart"></i>
                                            </a>
                                        @endauth
                                    </div>
                                    <div class="pro-details-compare">
                                        <a href="{{route('home.compare.add',['product'=>$product])}}"><i
                                                class="sli sli-refresh"></i><span
                                                class="ht-product-action-tooltip">
                                                    </span></a>
                                    </div>
                                </div>
                            @else
                                <div class="not-in-stock">
                                    <p class="text-white">ناموجود</p>
                                </div>
                            @endif
                        </form>


                    </div>
                </div>

                <div class="col-lg-6 col-md-6 order-1 order-sm-1 order-md-2">
                    <div class="product-details-img">
                        <div class="zoompro-border zoompro-span owl-stage">
                            <img width="90px" class="zoompro"
                                 src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}"
                                 data-zoom-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}"
                                 alt="{{$product->name}}"/>

                        </div>
                        <div id="gallery" class="mt-20 product-dec-slider">
                            <a data-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}"
                               data-zoom-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}">
                                <img width="90px"
                                     src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}"
                                     alt="{{$product->name}}">
                            </a>
                            @foreach ($product->images as $image)
                                <a data-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $image->image) }}"
                                   data-zoom-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $image->image) }}">
                                    <img width="90px" class="pl-0"
                                         src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $image->image) }}"
                                         alt="{{$product->name}}">
                                </a>
                            @endforeach


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="description-review-area pb-95">
        <div class="container">
            <div class="row" style="direction: rtl;">
                <div class="col-lg-8 col-md-8">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="{{count($errors)>0?'':'active'}}" data-toggle="tab" href="#des-details1">
                                توضیحات </a>
                            <a data-toggle="tab" href="#des-details3"> اطلاعات بیشتر </a>
                            <a data-toggle="tab" href="#des-details2" class="{{count($errors)>0?'active':''}}">
                                دیدگاه
                                ( {{$product->approvedComments()->count()}} )
                            </a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane {{count($errors)>0?'':'active'}}">
                                <div class="product-description-wrapper">
                                    <p class="text-justify" dir="rtl">
                                        {!! html_entity_decode($product->description) !!}
                                    </p>
                                </div>
                            </div>
                            <div id="des-details3" class="tab-pane">
                                <div class="product-anotherinfo-wrapper text-right">
                                    <ul>
                                        @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                                            <li>
                                                <span>{{ $attribute->attribute->name }} : </span>
                                                {{ $attribute->value }}
                                            </li>
                                        @endforeach

                                    </ul>

                                </div>
                            </div>
                            <div id="des-details2" class="tab-pane {{count($errors)>0?'active':''}}">

                                <div class="review-wrapper">
                                    @foreach($product->approvedComments as $comment)
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img height="50px"
                                                     src="{{$comment->user->avatar==null?asset('/images/home/Avatar.jpg'):$comment->user->avatar}}"
                                                     alt="{{$comment->user->name}}">
                                            </div>
                                            <div class="review-content w-100 text-right">
                                                <p class="text-right">
                                                    {{$comment->text}}
                                                </p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name">
                                                        <h4>{{$comment->user->name==null?'کاربر گرامی':$comment->user->name}}</h4>
                                                    </div>
                                                    <div data-rating-stars="5"
                                                         data-rating-readonly="true"
                                                         data-rating-value="{{ ceil($comment->user->rates->where('product_id',$product->id)->avg('rate')) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                @if(\Illuminate\Support\Facades\Auth::guest())
                                <div class="text-right alert alert-danger">برای نوشتن نظر باید وارد وب سایت شوید
                                <span class="mr-1"><a href="{{route('login')}}">ورود به وبسایت</a></span>
                                </div>
                                @else
                                    <div id="comments" class="ratting-form-wrapper text-right">
                                        <span> نوشتن دیدگاه </span>

                                        <div class="my-3" id="dataReadonlyReview"
                                             data-rating-stars="5"
                                             data-rating-value="0"
                                             data-rating-input="#rateInput">
                                        </div>

                                        <div class="ratting-form">
                                            <form action="{{route('home.comments.store',['product'=>$product->id])}}"
                                                  method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="rating-form-style mb-20">
                                                            <label> متن دیدگاه : </label>
                                                            <textarea name="text"></textarea>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="rate" id="rateInput" value="0">
                                                    <div class="col-lg-12">
                                                        <div class="form-submit">
                                                            <input type="submit" value="ارسال">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="mt-3">
                                            @include('home.sections.errors')
                                        </div>

                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                {{--                    <div class="pro-dec-banner">--}}
                {{--                        <a href="#"><img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $product->primary_image) }}" alt=""></a>--}}
                {{--                    </div>--}}
            </div>
        </div>
    </div>
    </div>
    <div class="container">
        <div class="section-title text-center pt-3 pb-40">
            <h3 id="myH3"><span class="line-center">محصولات مشابه</span></h3>
        </div>

    <div class="shop-area   pb-100 mt-0">

            <div class="row flex-row-reverse text-right">

                <div class="col-lg-9 order-1 order-sm-1 order-md-2">
                    <!-- shop-top-bar -->

                    <div class="shop-bottom-area mt-35">
                        <div class="tab-content jump">
                            <div class="row ht-products" style="direction: rtl">
                                @foreach($similarProducts as $similarProduct)

                                    @if($similarProduct->category->id===$product->category->id && $product->id != $similarProduct->id && $similarProduct->is_active=='فعال')
                                             <div class="col-xl-4 com-md-6 col-lg-6 col-sm-6">
                                                <!--Product Start-->

                                                <div
                                                    class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                                    <div class="ht-product-inner">
                                                        <div class="ht-product-image-wrap">
                                                            <a href="{{route('home.products.show',['product'=>$similarProduct->slug])}}"
                                                               class="ht-product-image">
                                                                <img
                                                                     src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $similarProduct->primary_image) }}"
                                                                     alt="{{ $similarProduct->name }}"/>
                                                            </a>
                                                            <div class="ht-product-action">
                                                                <ul>
                                                                    <li>
                                                                        <a href="#" data-toggle="modal"
                                                                           data-target="#productModal-{{$similarProduct->id}}"><i
                                                                                class="showDetail sli sli-magnifier"></i><span
                                                                                class=" ht-product-action-tooltip"> مشاهده سریع
                                                    </span></a>
                                                                    </li>
                                                                    <li>
                                                                        @auth
                                                                            @if($similarProduct->checkUserWishlist(auth()->id()))
                                                                                <a href="{{route('home.wishlist.remove',['product'=>$similarProduct->id])}}"><i
                                                                                        class="fas fa-heart"
                                                                                        style="color: red"></i>
                                                                                    <span
                                                                                        class="ht-product-action-tooltip">
                                                            به لیست علاقه مندی ها اضافه شده است
                                                        </span>
                                                                                </a>
                                                                            @else
                                                                                <a href="{{route('home.wishlist.add',['product'=>$similarProduct->id])}}"><i
                                                                                        class="sli sli-heart"></i>
                                                                                    <span
                                                                                        class="ht-product-action-tooltip">
                                                            افزودن به علاقه مندی ها
                                                        </span>
                                                                                </a>

                                                                            @endif

                                                                        @else
                                                                            <a href="{{route('home.wishlist.add',['product'=>$similarProduct->id])}}"><i
                                                                                    class="sli sli-heart"></i>
                                                                                <span
                                                                                    class="ht-product-action-tooltip">
                                                                   افزودن به علاقه مندی ها
                                                                   </span>
                                                                            </a>
                                                                        @endauth
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{route('home.compare.add',['product'=>$similarProduct])}}"><i
                                                                                class="sli sli-refresh"></i><span
                                                                                class="ht-product-action-tooltip"> مقایسه
                                                    </span></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="ht-product-content">
                                                            <div class="ht-product-content-inner">
                                                                <div class="ht-product-categories">
                                                                    <a href="#">{{ $similarProduct->category->name }}</a>
                                                                </div>
                                                                <h4 class="ht-product-title text-right">
                                                                    <a href="#"> {{ $similarProduct->name }} </a>
                                                                </h4>
                                                                <div class="ht-product-price">
                                                                    @if($similarProduct->quantity_check)
                                                                        @if($similarProduct->sale_check)
                                                                            <span class="new">
                                                        {{ number_format($similarProduct->sale_check->sale_price) }}
                                                        تومان
                                                    </span>
                                                                            <span class="old">
                                                        {{ number_format($similarProduct->sale_check->price) }}
                                                        تومان
                                                    </span>
                                                                        @else
                                                                            <span class="new">
                                                        {{ number_format($similarProduct->price_check->price) }}
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
                                                                         data-rating-value="{{ ceil($similarProduct->rates->avg('rate')) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <a href="{{route('home.products.show',['product'=>$similarProduct->slug])}}"
                                                               style="background-color: #418ed7;color: white"
                                                               class="btn btn-primary">مشاهده جزییات محصول</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--Product End-->
                                            </div>

                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @foreach ($similarProducts as $similarProduct)
        <div class="modal fade" id="productModal-{{$similarProduct->id}}" tabindex="-1" role="dialog">
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
                                    <h2 class="text-right mb-4">{{ $similarProduct->name }}</h2>

                                    <p class="text-right">
                                        {!! html_entity_decode($similarProduct->description) !!}
                                    </p>
                                    <div class="pro-details-list text-right">
                                        <ul class="text-right">
                                            @foreach ($similarProduct->attributes()->with('attribute')->get() as $attribute)
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
                                        @if($similarProduct->category->parent_id==0)
                                            <ul>
                                                <a href="{{route('home.categories.show',['category'=>$similarProduct->category->slug])}}">{{ $similarProduct->category->name }}</a>
                                            </ul>
                                        @else
                                            <ul>
                                                <li><a href="{{route('home.categories.show',['category'=>$similarProduct->category->slug])}}">{{$similarProduct->category->parent->name}}
                                                        ,{{ $similarProduct->category->name }}</a></li>
                                            </ul>
                                        @endif

                                    </div>
                                    <div class="pro-details-meta">
                                        <span>تگ ها :</span>
                                        <ul>
                                            @foreach ($similarProduct->tags as $tag)
                                                <li><a href="{{route('tags.show',['tag'=>$tag->name])}}">{{ $tag->name }}{{ $loop->last ? '' : '،' }}</a></li>

                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="tab-content quickview-big-img">
                                    <div id="pro-primary-{{$similarProduct->id}}" class="tab-pane fade show active">
                                        <img
                                            src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $similarProduct->primary_image) }}"
                                            alt="{{$similarProduct->name}}"/>
                                    </div>
                                    @foreach ($similarProduct->images as $image)
                                        <div id="pro-{{$image->id}}" class="tab-pane fade">
                                            <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $image->image) }}"
                                                 alt="{{$similarProduct->name}}"/>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Thumbnail Large Image End -->
                                <!-- Thumbnail Image End -->
                                <div class="quickview-wrap mt-15">
                                    <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                        <a class="active" data-toggle="tab" href="#pro-primary-{{$similarProduct->id}}">
                                            <img
                                                src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $similarProduct->primary_image) }}"
                                                alt=""/>
                                        </a>
                                        @foreach ($similarProduct->images as $image)
                                            <a data-toggle="tab" href="#pro-{{$image->id}}">
                                                <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PAT') . $image->image) }}"
                                                     alt="{{$similarProduct->name}}"/>
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

