@extends('admin.layouts.admin')

@section('title')
    index orders
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
                <h5 class="font-weight-bold mb-3 mb-md-0 ">لیست سفارشات ({{ $orders->total() }})</h5>
            </div>

            <div>
                <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>وضعیت</th>
                        <th>مبلغ</th>
                        <th>نوع پرداخت</th>
                        <th>وضعیت پرداخت </th>
                        <th>شماره سفارش</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $key => $order)
                        <tr class="btr">
                            <th>
                                {{ $orders->firstItem() + $key }}
                            </th>
                            <th>
                                {{$order->user->name==null?'کاریر':$order->user->name}}
                            </th>
                            <th>
                                {{$order->status}}
                            </th>
                            <th>
                                {{number_format($order->total_amount)}}
                            </th>
                            <th>
                                {{$order->payment_type}}
                            </th>
                            <th>
                                <span class="{{$order->getRawOriginal('payment_status')?'text-success':'text-danger'}}">{{$order->payment_status}}</span>

                            </th>
                            <th>
                                {{$order->order_number}}
                            </th>
                            <th>
                                <a class="btn btn-sm btn-outline-success"
                                   href="{{ route('admin.orders.show', ['order' => $order->id]) }}">نمایش</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $orders->render() }}
            </div>

        </div>

    </div>
@endsection
