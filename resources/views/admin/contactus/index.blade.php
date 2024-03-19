@extends('admin.layouts.admin')

@section('title')
    index contactus
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
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0 ">لیست فرم های ارسالی ({{ $contactus->total() }})</h5>
            </div>
            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>موضوع</th>
                        <th>متن</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($contactus as $key =>$singleContactus)

                        <tr class="btr">
                            <th>
                                {{ $contactus->firstItem() + $key }}
                            </th>
                            <th>
                                {{ $singleContactus->name }}
                            </th>
                            <th>
                                {{ $singleContactus->email }}
                            </th>
                            <th>
                                {{ $singleContactus->subject }}
                            </th>
                            <th>
                                {{ $singleContactus->text }}
                            </th>
                            <th>
                                <a class="btn btn-sm btn-outline-success"
                                   href="{{ route('admin.contactus.show', ['form' => $singleContactus->id]) }}">نمایش</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $contactus->render() }}
            </div>


        </div>
    </div>
@endsection
