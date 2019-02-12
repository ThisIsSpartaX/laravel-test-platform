<h1>
    Signup for our Customer Appreciation Club
</h1>
<div class="form-block" style="max-width: 500px;">
{!! Form::open(array('url' => URL::to('/customers'), 'method' => 'post', 'files'=> true, 'id' => 'customer-form')) !!}

<!-- Notifications -->
    @include('admin.notifications')
    <br/>

    <div class="">
        <div class="">
            <div class="form-group">
                {!! Form::label('first_name', 'First Name: *', ['class' => 'input__label']) !!}
                {!! Form::text('first_name', null, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('last_name', 'Last Name: *', ['class' => 'input__label']) !!}
                {!! Form::text('last_name', null, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phone', 'Phone: *', ['class' => 'input__label']) !!}
                {!! Form::text('phone', null, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email: *', ['class' => 'input__label']) !!}
                {!! Form::email('email', null, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('favorite_menu_item', 'Favorite menu item:', ['class' => 'input__label']) !!}
                {!! Form::text('favorite_menu_item', null, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group" style="position:relative">
                {!! Form::label('birthday_date', 'What is your birthday day and month?:', ['class' => 'input__label']) !!}
                {!! Form::text('birthday_date', null, array('id' => 'datetimepicker1', 'class' => 'form-control', 'style' => 'position: relative')) !!}
            </div>

            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="#" class="btn btn-default">Cancel</a>
            </div>
        </div>

    </div>
    {!! Form::close() !!}
</div>