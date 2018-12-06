@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Редактирование заказа
    @parent
@stop

@section('header_styles')
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}"/>
@stop

{{-- Page content --}}
@section('content')
    <div class="navigation--horizontal">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs text-xs">
            <a class="text-black" href="{{ route('admin') }}">Административная панель</a> &#8226; <a class="text-black"
                                                                                                     href="{{ route('admin.orders') }}">Заказы</a>
            &#8226; Редактирование заказа #{{ $order->id }}
        </div>
        <h1>Редактирование заказа #{{ $order->id }}</h1>
    </div>

    {!! Form::open(array('url' => URL::to('admin/orders/' . $order->id), 'method' => 'post', 'files'=> true, 'id' => 'order-form', 'data-order-id' => ''.$order->id)) !!}

    <!-- Notifications -->
    @include('admin.notifications')
    <br/>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('partner_id', 'Партнер: *', ['class' => 'input__label']) !!}
                {!! Form::select('partner_id', $partnersList, $order->partner_id, array('class' => 'form-control select2', 'id' => 'select2_sample4', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('client_email', 'Емейл Клиента: *', ['class' => 'input__label']) !!}
                {!! Form::text('client_email', $order->client_email, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group" style="position:relative">
                {!! Form::label('delivery_at', 'Дата доставки: *', ['class' => 'input__label']) !!}
                {!! Form::text('delivery_dt', $order->delivery_dt, array('class' => 'form-control datetimepicker', 'style' => 'position:relative;', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Статус: *', ['class' => 'input__label']) !!}
                {!! Form::select('status', $statuses, $order->status, array('class' => 'form-control', 'placeholder' => '-- Статус --'))!!}
            </div>
        </div>
        <div class="col-md-8">
            <div id="products">
                <div class="row">
                    <div id="order-products-block" class="col-md-12">
                        <label>Товары *</label>
                        @if($order->orderProducts->count())
                            <table id="order-products-list" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Наименование
                                        </th>
                                        <th>
                                            Цена
                                        </th>
                                        <th>
                                            Количество
                                        </th>
                                        <th>
                                            Сумма
                                        </th>
                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($order->orderProducts as $orderProduct)
                                        <tr id="order-product-{{ $orderProduct->product->id }}" class="product-row">
                                            <td class="col-sm-6">
                                                <b>{{ $orderProduct->product->name }}</b>
                                                {!! Form::hidden('product_id['.$orderProduct->product->id.']', $orderProduct->product->id) !!}
                                            </td>
                                            <td class="col-sm-2">
                                                <b>@money($orderProduct->price)</b>
                                            </td>
                                            <td class="col-sm-2">
                                                <div>
                                                    {!! Form::number('product['.$orderProduct->product->id.'][quantity]', $orderProduct->quantity, array('class' => 'order-product-quantity form-control', 'required' => 'required', 'min' => '1', 'data-product-id' => $orderProduct->product->id )) !!}
                                                </div>
                                            </td>
                                            <td class="text-center col-sm-3">
                                                <b>@money($orderProduct->calculateSum())</b>
                                            </td>
                                            <td class="col-sm-2 text-center">
                                                <div>
                                                    <a id="order-product-remove" href="#" class="btn text-danger" data-product-id="{{ $orderProduct->product->id }}"><i class="glyphicon glyphicon-remove-sign"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div><b>Нет товаров</b></div>
                        @endif
                    </div>
                    <div id="product-selector" class="col-md-12">
                        <table id="order-products-list" class="table table-striped">
                            <tbody>
                                <tr id="" class="product-row">
                                    <td class="order-product col-sm-6">
                                        {!! Form::select('product_new_id', $productsList, $order->orderProducts, array('id' => 'new-product-id', 'class' => 'form-control', 'required' => 'required'), $disabledProducts) !!}
                                    </td>
                                    <th class="col-sm-2">

                                    </th>
                                    <td class="col-sm-2">
                                        <div>
                                            {!! Form::number('quantity', 1, array('id' => 'new-product-quantity', 'class' => 'form-control', 'required' => 'required', 'min' => '1')) !!}
                                        </div>
                                    </td>
                                    <td class="col-sm-2">

                                    </td>
                                    <td class="col-sm-2 text-center">
                                        <div>
                                            <a id="order-product-add" href="#" class="btn"><i class="glyphicon glyphicon-plus-sign"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <b>Сумма заказа:</b> <span id="order-sum" class="h4">@money($order->calculateSum())</span>
            </div>
            <br/>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.orders') }}" class="btn btn-default">Отмена</a>
            </div>
        </div>

    </div>
    {!! Form::close() !!}
    <!--main content ends-->
@stop
{{-- page level scripts --}}
@section('footer_scripts')
@stop