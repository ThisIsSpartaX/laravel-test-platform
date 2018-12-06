@extends('admin.layouts.default')

{{-- Page title --}}
@section('title'){{ 'Заказы' }} @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="navigation--horizontal">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs text-xs">
            <a class="text-black" href="{{ route('admin') }}">Административная панель</a> &#8226; Заказы
        </div>
        <h1>Заказы</h1>
    </div>

@if ($orders->count())
    <table id="orders-list" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Партнер</th>
            <th>Стоимость</th>
            <th>Наименование - Состав (шт.)</th>
            <th>Статус</th>
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
                            <td>{{ $orderProduct->product->name }}</td>
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
    Записей нет
@endif



@stop