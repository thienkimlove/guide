@extends('admin.template')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tướng</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if ($content->id)
                <h2>Chỉnh sửa</h2>
                {!! Form::model($content, ['method' => 'PATCH', 'route' => [$model.'.update', $content->id], 'files' => true]) !!}
            @else
                <h2>Thêm mới</h2>
                {!! Form::model($content, ['route' => [$model.'.store'], 'files' => true]) !!}
            @endif

            <div class="form-group">
                {!! Form::label('title', 'Tên tướng') !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('image', 'Ảnh') !!}
                @if ($content->image)
                    <img src="{{url('img/cache/small/' . $content->image)}}"/>
                    <hr>
                @endif
                {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>

                <div class="form-group">
                    {!! Form::label('ti_le_thang', 'Tỉ lệ thắng') !!}
                    {!! Form::number('ti_le_thang', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('ti_le_thua', 'Tỉ lệ thua') !!}
                    {!! Form::number('ti_le_thua', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('ti_le_cam', 'Tỉ lệ cấm') !!}
                    {!! Form::number('ti_le_cam', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('ti_le_chon', 'Tỉ lệ chọn') !!}
                    {!! Form::number('ti_le_chon', null, ['class' => 'form-control']) !!}
                </div>

            <div class="form-group">
                {!! Form::submit('Lưu', ['class' => 'btn btn-primary form-control']) !!}
            </div>

            {!! Form::close() !!}

            @include('admin.list')

        </div>
    </div>
@endsection