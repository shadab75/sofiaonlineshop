@extends('admin.layouts.admin')

@section('title')
    index blogs
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

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0 ">لیست مقالات ({{ $blogs->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.blogs.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد مقاله
                </a>

            </div>

            <div>
                <table class=" table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>وضعیت</th>
                        <th>نویسنده</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($blogs as $key => $blog)
                        <tr class="btr">
                            <th>
                                {{ $blogs->firstItem() + $key }}
                            </th>
                            <th>
                                {{ $blog->title }}
                            </th>
                            <th>
                                <span
                                  class="{{ $blog->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                        {{ $blog->is_active }}
                                    </span>
                            </th>
                            <th>
                                {{ $blog->author }}
                            </th>

                            <th>
                                <a class="btn btn-sm btn-outline-success"
                                   href="{{ route('admin.blogs.show', ['blog' => $blog->id]) }}">نمایش</a>
                                <a class="btn btn-sm btn-outline-info mr-3"
                                   href="{{ route('admin.blogs.edit', ['blog' => $blog->id]) }}">ویرایش</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $blogs->render() }}
            </div>

        </div>

    </div>
@endsection
