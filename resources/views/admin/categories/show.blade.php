@extends('admin.layouts.admin')
@section('title')
    show category
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویژگی : {{$category->name}}</h5>
            </div>
            <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام</label>
                        <input class="form-control" value="{{$category->name}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label> نام انگلیسی</label>
                        <input class="form-control" value="{{$category->slug}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label> والد</label>
                        <div class="form-control div-disabled">
                            @if ($category->parent_id == 0)
                                بدون والد
                            @else
                                {{ $category->parent->name }}
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت</label>
                        <input class="form-control" value="{{$category->is_active}}" disabled type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input class="form-control" value="  {{jdate($category->created_at)->addHours()}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="keywords">کلمات کلیدی</label>
                        <textarea id="keywords" rows="3" name="keywords" disabled class="form-control">{{$category->keywords}}</textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label><strong>توضیحات</strong></label>
                        <div>

                            {!! html_entity_decode($category->description) !!}

                        </div>                    </div>
                    <div class="col-md-12">
                        <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <label> ویژگی ها</label>
                            <div class="div-disabled form-control">
                             @foreach($category->attributes as $attribute)
                                 {{ $attribute->name }} {{ $loop-> last ? '':',' }}
                             @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label> ویژگی های قابل فیلتر</label>
                            <div class="div-disabled form-control">
                                @foreach($category->attributes()->wherePivot('is_filter',1)->get() as $attribute)
                                    {{$attribute->name}}{{$loop->last?'':','}}
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label> ویژگی متغیر </label>
                            <div class="div-disabled form-control">
                                @foreach($category->attributes()->wherePivot('is_variation',1)->get() as $attribute)
                                    {{$attribute->name}}{{$loop->last?'':','}}
                                @endforeach
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection
