@extends('admin.layouts.admin')
@section('title')
    edit setting
@endsection
@section('script')
    <script>
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.setting.update',['setting'=>$setting->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="address">آدرس</label>
                        <input class="form-control" name="address"  type="text"  value="{{$setting->address}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">تلفن 1 </label>
                        <input class="form-control" name="telephone1"  type="text" value="{{$setting->telephone}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">تلفن 2 </label>
                        <input class="form-control" name="telephone2"  type="text" value="{{$setting->telephone2}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">ایمیل </label>
                        <input class="form-control" name="email"  type="text" value="{{$setting->email}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">طول جغرافیایی </label>
                        <input class="form-control" name="longitude"  type="text" value="{{$setting->longitude}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">عرض جغرافیایی </label>
                        <input class="form-control" name="latitude"  type="text" value="{{$setting->latitude}}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">ساعات کاری</label>
                        <input class="form-control" name="workinghours"  type="text" value="{{$setting->workinghours}}" >
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">توضیح</label>
                        <textarea class="form-control"  id="description" name="description">{{$setting->description}}</textarea>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.setting.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
