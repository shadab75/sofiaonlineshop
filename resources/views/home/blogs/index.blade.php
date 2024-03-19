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
                    <li class="active">مقالات</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="shop-area pt-95 pb-100 pr-30">
        <div class="container">
            <div class="row flex-row-reverse text-right">

                <div class="col-lg-12 order-1 order-sm-1 order-md-2">
                    <!-- shop-top-bar -->

                    <div class="shop-bottom-area mt-35">
                        <div class="tab-content jump">
                            <div class="row ht-products" style="direction: rtl">
                                @foreach ($blogs as $blog)
                                    <div class="col-xl-4 com-md-6 col-lg-6 col-sm-6">
                                        <!--Product Start-->

                                        <div class="card mt-3">
                                            <div class="card__header">
                                                <a href="{{route('home.blogs.show',['blog'=>$blog->slug])}}">
                                                    <img style="max-width: 100%;display: block "
                                                         src="{{ asset(env('BLOG_IMAGES_UPLOAD_PAT') . $blog->image) }}" alt="{{$blog->title}}" class="card__image" width="600">
                                                </a>
                                            </div>
                                            <div class="card__body" dir="rtl">
                                                <span class="tag align-self-end tag-blue" >صوفیا</span>
                                                <h4>{{$blog->title}}</h4>

                                             </div>

                                            <div class="card__footer" dir="rtl">
                                                <div class="user">
                                                    <div class="user__info text-right">
                                                        <h5>{{$blog->author}}</h5>
                                                        <small>{{jdate($blog->created_at)}}</small>
                                                    </div>
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
                        {{ $blogs->render() }}
                    </div>


                </div>

            </div>
        </div>
    </div>

@endsection
