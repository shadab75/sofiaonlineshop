@extends('admin.layouts.admin')
v
@section('title')
    index brands
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $(".search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".table .btr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>آدرس</th>
                        <th>متن</th>
                        <th>تلفن شماره یک</th>
                        <th>تلفن شماره دو</th>
                        <th>ایمیل</th>
                        <th>طول جغرافیایی</th>
                        <th>عرض جغرافیایی</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($settings as $key => $setting)

                        <tr class="btr">
                            <th>
                                {{$setting->id}}
                            </th>
                            <th>
                                {{ $setting->address }}
                            </th>
                            <th>
                                {{ $setting->description }}
                            </th>
                            <th>
                                {{ $setting->telephone }}
                            </th>
                            <th>
                                {{ $setting->telephone2 }}
                            </th>
                            <th>
                                {{ $setting->email }}
                            </th>
                            <th>
                                {{ $setting->longitude }}
                            </th>
                            <th>
                                {{ $setting->latitude }}
                            </th>

                            <th>
                                <a class="btn btn-sm btn-outline-success"
                                   href="{{ route('admin.setting.show', ['setting' => $setting->id]) }}">نمایش</a>
                                <a class="btn btn-sm btn-outline-info mr-3"
                                   href="{{ route('admin.setting.edit', ['setting' => $setting->id]) }}">ویرایش</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
