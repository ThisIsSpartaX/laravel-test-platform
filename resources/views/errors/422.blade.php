@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <h1>
            Oops!
        </h1>
        <h2>
            We can't seem to find the<br/> page you're looking for.
        </h2>
        <p><b>Error code: <span>{{ $errors['status'] }}</span> ({{ $errors['message'] }})</b></p>
    </div>
</div>
@endsection