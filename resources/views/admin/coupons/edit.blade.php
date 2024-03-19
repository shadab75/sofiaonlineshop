@extends('admin.layouts.admin')
@section('title')
    edit attribute
@endsection

@section('script')
<script>
    $('#expiredDate').MdPersianDateTimePicker({
        targetTextSelector: '#expireInput',
        englishNumber: true,
        enableTimePicker: true,
        textFormat: 'yyyy-MM-dd HH:mm:ss',
    });
</script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویراش کوپن {{$coupon->name}}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.coupons.update',['coupon'=>$coupon->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{$coupon->name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>کد</label>
                        <input class="form-control" value="  {{$coupon->code}}"  type="text" name="code">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type">نوع</label>
                        <select class="form-control" id="type" name="type">
                            <option value="amount" {{ $coupon->getRawOriginal('type')=='amount' ? 'selected' : ''}}>مبلغی</option>
                            <option value="percentage" {{$coupon->getRawOriginal('type')=='percentage' ? 'selected' : ''}}>درصدی</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="amount">مبلغ</label>
                        <input class="form-control" id="amount" name="amount"  type="text" value="{{$coupon->amount}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="percentage">درصد</label>
                        <input class="form-control" id="percentage" value="{{$coupon->percentage}}" name="percentage"  type="text" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="max_percentage_amount">حداکثر مبلغ برای نوع درصدی</label>
                        <input class="form-control" id="max_percentage_amount" name="max_percentage_amount" value="{{$coupon->max_percentage_amount}}"  type="text" >
                    </div>
                    <div class="form-group col-md-3">
                        <label> تاریخ انقضا </label>
                        <div class="input-group">
                            <div class="input-group-prepend order-2">
                              <span class="input-group-text"
                                    id="expiredDate">
                                 <i class="fas fa-clock"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control"
                                   id="expireInput"
                                   name="expired_at"
                                   value="{{verta($coupon->expired_at)}}"
                            >
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description"  name="description"
                                  rows="4">{{$coupon->description}}</textarea>
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>


@endsection
