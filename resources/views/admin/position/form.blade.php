@extends('admin.template')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Position</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (!empty($position))
            <h2>Edit</h2>
            {!! Form::model($position, ['method' => 'PATCH', 'route' => ['positions.update', $position->id]]) !!}
            @else
                <h2>Add</h2>
                {!! Form::model($position = new App\Position, ['route' => ['positions.store']]) !!}
            @endif

            <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            </div>

            {!! Form::close() !!}

            @include('admin.list')

        </div>
    </div>
@endsection