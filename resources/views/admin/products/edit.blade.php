@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Edit Product #{{ $product->id }}
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
            <a class="text-black" href="{{ route('admin') }}">Dashboard</a> &#8226; <a class="text-black"
                                                                                                     href="{{ route('admin.products') }}">Products</a>
            &#8226; Edit Product #{{ $product->id }}
        </div>
        <h1>Edit Product #{{ $product->id }}</h1>
    </div>

    {!! Form::open(array('url' => URL::to('admin/products/' . $product->id), 'method' => 'post', 'files'=> true, 'id' => 'product-form', 'data-product-id' => ''.$product->id)) !!}

    <!-- Notifications -->
    @include('admin.notifications')
    <br/>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('name', 'Title: *', ['class' => 'input__label']) !!}
                {!! Form::text('name', $product->name, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('price', 'Price: *', ['class' => 'input__label']) !!}
                {!! Form::text('price', $product->price, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('price', 'Quantity:', ['class' => 'input__label']) !!}
                <br/>
                {{ $product->inventoryProducts->sum('count') }}
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Status: *', ['class' => 'input__label']) !!}
                {!! Form::select('status', $statuses, $product->status, array('class' => 'form-control', 'placeholder' => '-- Status --'))!!}
            </div>
            <br/>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.products') }}" class="btn btn-default">Cancel</a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--main content ends-->
@stop
{{-- page level scripts --}}
@section('footer_scripts')
@stop