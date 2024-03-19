@extends('admin.layouts.admin')
@section('title')
    show role
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 p-4 bg-white">

            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input class="form-control" name="name" disabled type="text"  value="{{$form->name}}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="email">ایمیل</label>
                    <input class="form-control" name="email" disabled type="text" value="{{$form->email}}" >
                </div>
                <div class="form-group col-md-3">
                    <label for="subject">موضوع </label>
                    <input class="form-control" name="subject" disabled type="text" value="{{$form->subject}}" >
                </div>
                <div class="form-group col-md-12">
                    <label for="text">متن </label>
                    <textarea name="text" disabled class="form-control">{{$form->text}}</textarea>
                </div>
            </div>
            <a href="{{ route('admin.contactUs.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>

        </div>

    </div>

@endsection
