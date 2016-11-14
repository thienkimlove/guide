@extends('admin.template')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ucfirst($realModel)}}</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (!empty($modelContent))
            <h2>Edit</h2>
            {!! Form::model($modelContent, [
                'method' => 'PATCH',
                'url' => url('admin/'.$realModel.'/'.$modelContent->id),
                'files' => true
             ]) !!}
            @else
                <h2>Add</h2>
                {!! Form::model($modelContent = new $modelName, ['url' => url('admin/'.$realModel), 'files' => true]) !!}
            @endif

            @foreach ($fields as $field)
               @if ($field['edit'])
                        @if ($field['type'] == 'string')
                            <div class="form-group">
                                {!! Form::label($field['value'], $field['name']) !!}
                                {!! Form::text($field['value'], null, ['class' => 'form-control']) !!}
                            </div>
                        @elseif ($field['type'] == 'text')
                            <div class="form-group">
                                {!! Form::label($field['value'], $field['name']) !!}
                                {!! Form::textarea($field['value'], null, ['class' => 'form-control']) !!}
                            </div>
                        @elseif ($field['type'] == 'editor')
                            <div class="form-group">
                                {!! Form::label($field['value'], $field['name']) !!}
                                {!! Form::textarea($field['value'], null, ['class' => 'form-control ckeditor']) !!}
                            </div>

                        @elseif ($field['type'] == 'image')
                            <div class="form-group">
                                {!! Form::label($field['value'], $field['name']) !!}
                                @if ($modelContent->{$field['value']})
                                    <img src="{{url('img/cache/small/' . $modelContent->{$field['value']})}}" />
                                    <hr>
                                @endif
                                {!! Form::file($field['value'], null, ['class' => 'form-control']) !!}
                            </div>
                        @elseif ($field['type'] == 'boolean')
                            <div class="form-group">
                                {!! Form::label($field['value'], $field['name']) !!}
                                {!! Form::checkbox($field['value'], null, null) !!}
                            </div>
                        @elseif ($field['type'] == 'config')
                            <div class="form-group">
                                {!! Form::label($field['value'], $field['name']) !!}
                                {!! Form::select($field['value'], $modelContent->{$field['relation_list']} , null, ['class' => 'form-control']) !!}
                            </div>
                        @elseif ($field['type'] == 'tag')
                            <div class="form-group">
                                {!! Form::label($field['value'], $field['name']) !!}
                                {!! Form::select($field['value'].'[]', \App\Tag::pluck('title', 'title')->all(), null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
                            </div>
                        @elseif ($field['type'] == 'relation')
                            <div class="form-group">
                                {!! Form::label($field['edit_value'], $field['name']) !!}
                                {!! Form::select($field['edit_value'], $modelContent->{$field['relation_list']} , null, ['class' => 'form-control']) !!}
                            </div>
                        @endif
                    @endif
            @endforeach

            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            </div>

            {!! Form::close() !!}

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

        </div>
    </div>
@stop

@section('footer')
    <script>
        $('#tag_list').select2({
            placeholder : 'choose or add new tag',
            tags : true //allow to add new tag which not in list.
        });
    </script>
@endsection