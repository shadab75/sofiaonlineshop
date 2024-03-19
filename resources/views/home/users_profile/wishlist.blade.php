@extends('home.layouts.home')

@section('title')
    صفحه لیست علاقه مندی ها
@endsection
@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}">صفحه اصلی</a>
                    </li>
                    <li class="active"> لیست علاقه مندی ها </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- my account wrapper start -->
    <div class="my-account-wrapper pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row text-right" style="direction: rtl;">
                            <div class="col-lg-3 col-md-4">
                                @include('home.sections.profile_sidebar')
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <div class="myaccount-content">
                                        <h3> لیست علاقه مندی ها </h3>
                                        <div class="review-wrapper">
                                         @if($wishlist->isEmpty())
                                             <div class="alert alert-danger">
                                                 لیست علاقه مندی های شما خالی میباشد
                                             </div>
                                         @else
                                                <div class="table-content table-responsive cart-table-content">
                                                    <table>
                                                        <thead>
                                                        <tr>
                                                            <th> تصویر محصول </th>
                                                            <th> نام محصول </th>
                                                            <th> حذف </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($wishlist as $item)
                                                            <tr>
                                                                <td class="product-thumbnail">
                                                                    <a href="{{route('home.products.show',['product'=>$item->product->slug])}}">
                                                                        <img height="100px"
                                                                            src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PAT').$item->product->primary_image)}}"
                                                                            alt=""></a>
                                                                </td>
                                                                <td class="product-name">
                                                                    <a href="{{route('home.products.show',['product'=>$item->product->slug])}}">
                                                                        {{$item->product->name}}
                                                                    </a>
                                                                </td>
                                                                <td class="product-name">
                                                                    <a href="{{route('home.wishlist.remove',['product'=>$item->product->id])}}"> <i class="sli sli-trash" style="font-size: 20px"></i> </a>
                                                                </td>
                                                            </tr>

                                                        @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>
                                         @endif


                                        </div>
                                    </div>

                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->


@endsection

