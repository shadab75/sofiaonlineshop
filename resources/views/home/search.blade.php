@extends('home.layouts.home')
@section('script')

   <script>
       $('#main-footer').css("margin-top",300);
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
                    <li class="active">نتایج جست و جو</li>
                </ul>
            </div>
        </div>
    </div>
<div class="shop-area pt-95 pb-100">
    <div class="container">
        <div class="row flex-row-reverse text-right">

            <div class="col-lg-12 order-1 order-sm-1 order-md-2">
                <!-- shop-top-bar -->

                <div class="shop-bottom-area mt-35">
                    <div class="tab-content jump">
                        <div class="row ht-products" style="direction: rtl">
                            @foreach ($products as $product)
                                <div class="col-xl-4 com-md-6 col-lg-6 col-sm-6">
                                    <!--Product Start-->

                                    <div
                                        class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                        <div class="ht-product-inner">
                                            <div class="ht-product-image-wrap">
                                                <a href="{{route('home.products.show',['product'=>$product->slug])}}"
                                                   class="ht-product-image">
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
                                                                            class="fas fa-heart"
                                                                            style="color: red"></i>
                                                                        <span
                                                                            class="ht-product-action-tooltip">
                                                            به لیست علاقه مندی ها اضافه شده است
                                                        </span>
                                                                    </a>
                                                                @else
                                                                    <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i
                                                                            class="sli sli-heart"></i>
                                                                        <span
                                                                            class="ht-product-action-tooltip">
                                                            افزودن به علاقه مندی ها
                                                        </span>
                                                                    </a>

                                                                @endif

                                                            @else
                                                                <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i
                                                                        class="sli sli-heart"></i>
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
                                                        <a href="#">{{ $product->category->name }}</a>
                                                    </div>
                                                    <h4 class="ht-product-title text-right">
                                                        <a href="#"> {{ $product->name }} </a>
                                                    </h4>
                                                    <div class="ht-product-price">
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

                                    <!--Product End-->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5" dir="rtl">
                    {{ $products->render() }}
                </div>


            </div>

        </div>
    </div>
</div>

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


@endsection
