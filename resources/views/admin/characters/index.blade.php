@extends('admin.template')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tướng</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên</th>
                                <th>Ảnh</th>
                                <th>Thắng</th>
                                <th>Thua</th>
                                <th>Cấm</th>
                                <th>Chọn</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contents as $content)
                                <tr>
                                    <td>{{$content->id}}</td>
                                    <td>{{$content->title}}</td>
                                    <td>{{$content->ti_le_thang}} %</td>
                                    <td>{{$content->ti_le_thua}} %</td>
                                    <td>{{$content->ti_le_cam}} %</td>
                                    <td>{{$content->ti_le_chon}} %</td>
                                    <td><img src="{{url('img/cache/small', $content->image)}}" /></td>
                                    <td>
                                        <button id-attr="{{$content->id}}"
                                                content-attr="{{$model}}"
                                                class="btn btn-primary btn-sm edit-content"
                                                type="button">
                                            Sửa
                                        </button>&nbsp;
                                        {!! Form::open(['method' => 'DELETE', 'route' => [$model.'.destroy', $content->id]]) !!}
                                        <button type="submit" class="btn btn-danger btn-mini">Xóa</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">{!!$contents->render()!!}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-primary add-content" content-attr="{{$model}}" type="button">Thêm mới</button>
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