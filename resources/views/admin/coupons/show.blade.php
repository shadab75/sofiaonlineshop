@extends('admin.layouts.admin')
@section('title')
    show coupon
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">کوپن : {{$coupon->name}}</h5>
            </div>
            <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام</label>
                        <input class="form-control" value="{{$coupon->name}}" disabled type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input class="form-control" value="  {{verta($coupon->created_at)->addHour()}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>کد</label>
                        <input class="form-control" value="  {{$coupon->code}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label>نوع</label>
                        <input class="form-control" value="  {{$coupon->type}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="amount">مبلغ</label>
                        <input class="form-control" id="amount" name="amount" disabled type="text" value="{{$coupon->amount}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="percentage">درصد</label>
                        <input class="form-control" id="percentage" value="{{$coupon->percentage}}" name="percentage" disabled type="text" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="max_percentage_amount">حداکثر مبلغ برای نوع درصدی</label>
                        <input class="form-control" id="max_percentage_amount" name="max_percentage_amount" value="{{$coupon->max_percentage_amount}}" disabled type="text" >
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ انقضا</label>
                        <input class="form-control" value="{{verta($coupon->expired_at)->addHour()}}" disabled type="text">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" disabled name="description"
                                  rows="4">{{$coupon->description}}</textarea>
                    </div>
                </div>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection
