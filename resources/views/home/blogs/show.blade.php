@extends('home.layouts.home')
@section('script')

{{--    <script>--}}
{{--        $('#main-footer').css("margin-top",300);--}}
{{--    </script>--}}

@endsection
@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}">صفحه اصلی</a>
                    </li>
                    <li>
                        <a href="{{route('home.index')}}">مقالات</a>
                    </li>

                    <li class="active">{{$blog->title}}</li>
                </ul>
            </div>
        </div>
    </div>
    <br><br><br>
<div class="container">
    <h3 class="text-center p-5" style="background: #f6f6f6;border-radius: 5px" >{{$blog->title}}</h3>
</div>
<div class="container text-right" style="text-align: justify" dir="rtl">

    <div class="blog-body" >
        <p class="blog-body" style="font-size: 18px;line-height: 40px">   {!! html_entity_decode($blog->body) !!}</p>
    </div>
</div>


@endsection
