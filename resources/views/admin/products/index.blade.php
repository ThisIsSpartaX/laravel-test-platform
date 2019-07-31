@extends('admin.layouts.default')

{{-- Page title --}}
@section('title'){{ 'Products' }} @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="navigation--horizontal">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs text-xs">
            <a class="text-black" href="{{ route('admin') }}">Dashboard</a> &#8226; Products
        </div>
        <h1>Products</h1>
    </div>

@if ($products->count())
    <table id="products-list" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
        <tr>
            <td><a href="{{ route('admin.products.edit', $product->id) }}">{{ $product->id }}</a></td>
            <td><a href="{{ route('admin.products.edit', $product->id) }}">{{ $product->name }}</a></td>
            <td>{!! $product->inventoryProducts->sum('count') !!}</td>
            <td>{{ $product->getPrice() }}</td>
            <td>{{ $product->getStatusText() }}</td>
        </tr>
        @endforeach
    </table>
    <div class="text-center">
        {!! $products->render() !!}
    </div>
@else
    No products
@endif



@stop