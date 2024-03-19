@extends('admin.layouts.admin')

@section('title')
    index tags
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
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تگ ها ({{ $tags->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.tags.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد تگ
                </a>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tags as $key => $tag)
                        <tr class="btr">
                            <th>
                                {{ $tags->firstItem() + $key }}
                            </th>
                            <th>
                                {{ $tag->name }}
                            </th>
                            <th>
                                <a class="btn btn-sm btn-outline-success"
                                   href="{{ route('admin.tags.show', ['tag' => $tag->id]) }}">نمایش</a>
                                <a class="btn btn-sm btn-outline-info mr-3"
                                   href="{{ route('admin.tags.edit', ['tag' => $tag->id]) }}">ویرایش</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $tags->render() }}
            </div>
        </div>

    </div>
@endsection
