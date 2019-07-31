@extends('admin.layouts.default')

{{-- Page title --}}
@section('title'){{ 'Orders' }} @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="navigation--horizontal">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs text-xs">
            <a class="text-black" href="{{ route('admin') }}">Dashboard</a> &#8226; Orders
        </div>
        <h1>Orders</h1>
    </div>

@if ($orders->count())
    <table id="orders-list" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Partner</th>
            <th>Price</th>
            <th>Items List (quantity)</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
        <tr>
            <td><a href="{{ route('admin.orders.edit', $order->id) }}">{{ $order->id }}</a></td>
            <td>{{ $order->partner->name }}</td>
            <td>@money($order->calculateSum())</td>
            <td>
                <table width="100%">
                    @foreach($order->orderProducts as $orderProduct)
                        <tr>
                            <td><a href="{{ route('admin.products.edit', $orderProduct->product->id) }}">{{ $orderProduct->product->name }}</a></td>
                            <td class="text-center">{{ $orderProduct->quantity }}</td>
                        </tr>
                    @endforeach
                </table>
            <td>{{ $order->getStatusText() }}</td>
        </tr>
        @endforeach
    </table>
    <div class="text-center">
        {!! $orders->render() !!}
    </div>
@else
    No Orders
@endif



@stop