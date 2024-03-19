@extends('admin.layouts.admin')
@section('title')
    edit attribute
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویراش مجوز {{$permission->dispaly_name}}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.permissions.update',['permission'=>$permission->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام انگلیسی</label>
                        <input class="form-control"   name="name" type="text" value="{{$permission->name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">نام نمایشی</label>
                        <input class="form-control"   name="display_name" type="text" value="{{$permission->display_name}}">
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>


@endsection
