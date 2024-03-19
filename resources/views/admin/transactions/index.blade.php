@extends('admin.layouts.admin')

@section('title')
    index transactions
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
                <h5 class="font-weight-bold mb-3 mb-md-0 ">لیست تراکنش ها ({{ $transactions->total() }})</h5>
            </div>

            <div>
                <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>شماره سفارش</th>
                        <th>مبلغ</th>
                        <th>ref_id</th>
                        <th>نام درگاه پرداخت </th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($transactions as $key => $transaction)
                        <tr class="btr">
                            <th>
                                {{ $transactions->firstItem() + $key }}
                            </th>
                            <th>
                                {{$transaction->user->name==null?'کاریر':$transaction->user->name}}
                            </th>
                            <th>
                                {{$transaction->order->order_number}}
                            </th>
                            <th>
                                {{number_format($transaction->amount)}}
                            </th>
                            <th>
                                {{$transaction->ref_id}}
                            </th>
                            <th>
                                {{$transaction->gateway_name}}
                            </th>

                            <th>
                                <span class="{{$transaction->getRawOriginal('status')?'text-success':'text-danger'}}">{{$transaction->status}}</span>

                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $transactions->render() }}
            </div>

        </div>

    </div>
@endsection
