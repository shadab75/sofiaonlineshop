@extends('admin.layouts.admin')
@section('title')
    show blogs
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">مقاله : {{$blog->title}}</h5>
            </div>
            <hr>
            <div class="row">
                <div class="row justify-content-center mb-3">
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="{{ url( env('BLOG_IMAGES_UPLOAD_PAT').$blog->image ) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label>عنوان</label>
                    <input class="form-control" value="{{$blog->title}}" disabled type="text">
                </div>



                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control" value="{{$blog->is_active}}" disabled type="text">
                </div>
                <div class="form-group col-md-3">
                    <label>نویسنده</label>
                    <input class="form-control" value="{{$blog->author}}" disabled type="text">
                </div>

                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" value="  {{jdate($blog->created_at)->addHours()}}" disabled type="text">
                </div>
                <div class="form-group col-md-12">
                    <label for="keywords">کلمات کلیدی</label>
                    <textarea id="keywords" rows="3" name="keywords" disabled class="form-control">{{$blog->keywords}}</textarea>
                </div>
                <div class="form-group col-md-12">
                    <label><strong>توضیحات</strong></label>
                    <div>
                        {!! html_entity_decode($blog->body) !!}

                    </div>
                </div>

            </div>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection
