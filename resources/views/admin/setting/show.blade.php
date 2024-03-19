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
                        <label for="address">آدرس</label>
                        <input class="form-control" name="address" disabled type="text"  value="{{$setting->address}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">تلفن 1 </label>
                        <input class="form-control" name="telephone1" disabled type="text" value="{{$setting->telephone}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">تلفن 2 </label>
                        <input class="form-control" name="telephone2" disabled type="text" value="{{$setting->telephone2}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">ایمیل </label>
                        <input class="form-control" name="email" disabled type="text" value="{{$setting->email}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">طول جغرافیایی </label>
                        <input class="form-control" name="longitude" disabled type="text" value="{{$setting->longitude}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">عرض جغرافیایی </label>
                        <input class="form-control" name="latitude" disabled type="text" value="{{$setting->latitude}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">ساعت کاری </label>
                        <input class="form-control" name="latitude" disabled type="text" value="{{$setting->workinghours}}" >
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">توضیح</label>
                        <div>

                            {!! html_entity_decode($setting->description) !!}

                        </div>
                    </div>


                </div>
                <a href="{{ route('admin.setting.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>

        </div>

    </div>

@endsection
