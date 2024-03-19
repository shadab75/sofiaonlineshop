@extends('admin.layouts.admin')
@section('title')
    create attribute
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

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 p-4 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد کوپن</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="code">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{old('name')}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="code">کد</label>
                        <input class="form-control" id="code" name="code" type="text" value="{{old('code')}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="code">نوع</label>
                         <select class="form-control" id="type" name="type">
                             <option value="amount">مبلغی</option>
                             <option value="percentage">درصدی</option>
                         </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="amount">مبلغ</label>
                        <input class="form-control" id="amount" name="amount" type="text" value="{{old('amount')}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="percentage">درصد</label>
                        <input class="form-control" id="percentage" name="percentage" type="text" value="{{old('percentage')}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="max_percentage_amount">حداکثر مبلغ برای نوع درصدی</label>
                        <input class="form-control" id="max_percentage_amount" name="max_percentage_amount" type="text" value="{{old('max_amount')}}" >
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
                                  >
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description"
                                  rows="4">{{old('description')}}</textarea>
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
