@extends('admin.template')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ucfirst($realModel)}}</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="input-group custom-search-form">
                        {!! Form::open(['method' => 'GET', 'url' => url('admin', $realModel) ]) !!}
                        <span class="input-group-btn">
                            <input type="text" value="{{$searchContent}}" name="q" class="form-control" placeholder="Search {{$realModel}}..">

                            <button class="btn btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
						
                        {!! Form::close() !!}


                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                @foreach ($fields as $field)
                                    @if ($field['display'])
                                      <th>{{$field['name']}}</th>
                                    @endif
                                @endforeach
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($modelContents as $model)
                                <tr>
                                    @foreach ($fields as $field)
                                        @if ($field['display'])
                                           @if ($field['type'] == 'relation')
                                                <td>{{isset($model->{$field['value']}->{$field['sub_value']}) ? $model->{$field['value']}->{$field['sub_value']} : 'NULL'}}</td>
                                           @elseif ($field['type'] == 'boolean')
                                                <td>{{ ($model->{$field['value']}) ? 'Yes' : 'No'  }}</td>
                                            @elseif ($field['type'] == 'text')
                                                <td>{!! str_limit($model->{$field['value']}, 200) !!}</td>
                                            @elseif ($field['type'] == 'image')
                                                <td><img src="{{url('img/cache/small/' . $model->{$field['value']})}}" /></td>
                                            @elseif ($field['type'] == 'config')
                                                <td>{{$model->{$field['sub_value']} }}</td>
                                            @else
                                                <td>{{ $model->{$field['value']} }}</td>
                                            @endif
                                        @endif
                                    @endforeach

                                    <td>
                                        <button id-attr="{{$model->id}}" content-attr="{{$realModel}}" class="btn btn-primary btn-sm edit-content" type="button">Edit</button>&nbsp;
                                        {!! Form::open(['method' => 'DELETE', 'url' => url('admin/'.$realModel.'/'.$model->id)]) !!}
                                               <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                        {!! Form::close() !!}
                                        @if ($realModel == 'posts')
                                            <button class="btn btn-primary btn-sm" type="button">
                                                <a target="_blank" href="{{url($model->slug.'.html')}}" style="color:#FFFFFF">View in Site</a>
                                            </button>
                                        @endif

                                        @if ($modules)
                                            @foreach ($modules as $k => $module)
                                                @if ($model->{$k})
                                                    {!! Form::open(['method' => 'DELETE', 'url' => url('admin/modules/'.$model->{$k}->id)]) !!}
                                                        <button type="submit" class="btn btn-danger btn-mini">Disable {{$module}}</button>
                                                        <input type="hidden" name="redirect_back" value="{{Request::url()}}" />
                                                    {!! Form::close() !!}
                                                @else
                                                    {!! Form::open(['method' => 'POST', 'url' => url('admin/modules')]) !!}
                                                    <input type="hidden" name="key_name" value="{{$module}}" />
                                                        <input type="hidden" name="key_type" value="{{$k}}" />
                                                        <input type="hidden" name="key_content" value="{{$realModel}}" />
                                                        <input type="hidden" name="key_value" value="{{$model->id}}" />
                                                        <input type="hidden" name="redirect_back" value="{{Request::url()}}" />
                                                        <button type="submit" class="btn btn-danger btn-mini">Enable {{$module}}</button>
                                                    {!! Form::close() !!}
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">{!!$modelContents->render()!!}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-primary add-content"  content-attr="{{$realModel}}" type="button">Add</button>
                        </div>
                    </div>


                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

    </div>
@endsection
@section('footer')
    <script>
        $(function(){
            $('.add-content').click(function(){
                window.location.href = window.baseUrl + '/admin/'+$(this).attr('content-attr')+'/create';
            });
            $('.edit-content').click(function(){
                window.location.href = window.baseUrl + '/admin/'+$(this).attr('content-attr')+'/' + $(this).attr('id-attr') + '/edit';
            });
        });
    </script>
@endsection