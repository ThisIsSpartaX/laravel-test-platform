@extends('layouts.app')

{{-- Page title --}}
@section('title'){{ 'Signup for our Customer Appreciation Club' }} @parent
@endsection

@section('content')
    <div class="container">
        <div class="row flex-column-reverse flex-lg-row">
            <div class="col-12 col-md-6 text-center">
                @include('pages.customers.customer-form')
            </div>
            <div class="col-12 col-md-6">
                <img src="{{ asset('images/gift-card-banner.png') }}" style="max-width: 300px;"/>
            </div>
        </div>
    </div>
@endsection

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'DD/MM'
            });
        });
    </script>
@stop
