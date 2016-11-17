@extends('admin.template')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Guide</h1>
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

            <h2>Thông tin chung</h2>

            <div class="form-group">
                {!! Form::label('title', 'Tiêu đề') !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
                <input type="hidden" id="store_content_id" value="{{!empty($content->id) ? $content->id : null}}" />
            </div>

            <div class="form-group">
                {!! Form::label('desc', 'Mô tả ngắn') !!}
                {!! Form::textarea('desc', null, ['class' => 'form-control']) !!}
            </div>



            <div class="form-group">
                {!! Form::label('character_id', 'Chọn Tướng') !!}
                {!! Form::select('character_id', array('' => 'Chọn Tướng') + App\Character::pluck('title', 'id')->all(), null, ['class' => 'form-control', 'id' => 'choose_character']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('position_id', 'Chọn vị trí') !!}
                {!! Form::select('position_id', array('' => 'Chọn vị trí') + App\Position::pluck('name', 'id')->all(), null, ['class' => 'form-control']) !!}
            </div>


                <div class="form-group">
                    {!! Form::label('uu_diem', 'Ưu điểm') !!}
                    {!! Form::textarea('uu_diem', null, ['class' => 'form-control ckeditor']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('nhuoc_diem', 'Nhược điểm') !!}
                    {!! Form::textarea('nhuoc_diem', null, ['class' => 'form-control ckeditor']) !!}
                </div>


                <div class="form-group">
                    {!! Form::label('giai_doan_dau_tran', 'Giai đoạn dầu trận') !!}
                    {!! Form::textarea('giai_doan_dau_tran', null, ['class' => 'form-control ckeditor']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('giai_doan_giua_tran', 'Giai đoạn giữa trận') !!}
                    {!! Form::textarea('giai_doan_giua_tran', null, ['class' => 'form-control ckeditor']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('giai_doan_cuoi_tran', 'Giai đoạn cuối trận') !!}
                    {!! Form::textarea('giai_doan_cuoi_tran', null, ['class' => 'form-control ckeditor']) !!}
                </div>

            <div class="form-group">
                {!! Form::label('image', 'Ảnh') !!}
                @if ($content->image)
                    <img src="{{url('img/cache/small/' . $content->image)}}"/>
                    <hr>
                @endif
                {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>

            <h3>Bảng bổ Trợ</h3>

            <div class="form-group">
                {!! Form::label('table_support_1', 'Bảng bổ trợ') !!}
                @if ($content->table_support_1)
                    <img src="{{url('img/cache/small/' . $content->table_support_1)}}"/>
                    <hr>
                @endif
                {!! Form::file('table_support_1', null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                <h3>Ngọc Bổ Trợ</h3>

                <div id="template_supplement" style="display: none">
                    <div>
                        <label>Chọn loại ngọc</label>
                        {!! Form::select('supplement_id[]', array('' => 'Chọn Ngọc Bổ Trợ') + App\Supplement::pluck('name', 'id')->all(), null) !!}

                        <label>Số lượng</label>
                        <input type="number" name="supplement_number[]" value=""/>
                        <input type="button" class="btn-danger delete-supplement" value="Xóa"/>
                    </div>
                </div>


                <div id="supplement" class="form-group">
                    @if ($content->supplements->count() > 0)
                        @foreach ($content->supplements as $supplement)
                            <div>
                                <label>Chọn loại ngọc</label>
                                {!! Form::select('supplement_id[]', array('' => 'Chọn Ngọc Bổ Trợ') + App\Supplement::pluck('name', 'id')->all(), $supplement->id) !!}

                                <label>Số lượng</label>
                                <input type="number" name="supplement_number[]" value="{{$supplement->pivot->number}}"/>
                                <input type="button" class="btn-danger delete-supplement" value="Xóa"/>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="form-group">
                    <button id="add-supplement" class="btn-success">Thêm</button>
                </div>
            </div>

            <div class="form-group">
                <h3>Trang Bị</h3>

                <div id="template_equipment" style="display: none">
                    <div>
                        <label>Chọn trang bị</label>
                        {!! Form::select('equipment_id[]', array('' => 'Chọn trang bị') + App\Equipment::pluck('name', 'id')->all(), null) !!}

                        <label>Loại trang bị</label>
                        {!! Form::select('equipment_type[]', array('' => 'Chọn loại trang bị') + config('equipment'), null) !!}

                        <input type="button" class="btn-danger delete-equipment" value="Xóa"/>
                    </div>
                </div>


                <div id="equipment" class="form-group">
                    @if ($content->equipments->count() > 0)
                        @foreach ($content->equipments as $equipment)
                            <div>
                                <label>Chọn trang bị</label>
                                {!! Form::select('equipment_id[]', array('' => 'Chọn trang bị') + App\Equipment::pluck('name', 'id')->all(), $equipment->id) !!}

                                <label>Loại trang bị</label>
                                {!! Form::select('equipment_type[]', array('' => 'Chọn loại trang bị') + config('equipment'), $equipment->pivot->type) !!}

                                <input type="button" class="btn-danger delete-equipment" value="Xóa"/>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="form-group">
                    <button id="add-equipment" class="btn-success">Thêm</button>
                </div>
            </div>


            <div class="form-group"wq>
                    <h3>Phép Bổ Trợ</h3>

                    <div id="template_support" style="display: none">
                        <div>
                            <label>Chọn phép bổ trợ</label>
                            {!! Form::select('support_id[]', array('' => 'Chọn phép bổ trợ') + App\Support::pluck('name', 'id')->all(), null) !!}

                            <label>Loại</label>
                            {!! Form::select('support_type[]', array('' => 'Chọn loại') + config('support'), null) !!}

                            <input type="button" class="btn-danger delete-support" value="Xóa"/>
                        </div>
                    </div>


                    <div id="support" class="form-group">
                        @if ($content->supports->count() > 0)
                            @foreach ($content->supports as $support)
                                <div>
                                    <label>Chọn phép bổ trợ</label>
                                    {!! Form::select('support_id[]', array('' => 'Chọn phép bổ trợ') + App\Support::pluck('name', 'id')->all(), $support->id) !!}

                                    <label>Loại</label>
                                    {!! Form::select('support_type[]', array('' => 'Chọn loại') + config('support'), $support->pivot->type) !!}

                                    <input type="button" class="btn-danger delete-support" value="Xóa"/>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <button id="add-support" class="btn-success">Thêm</button>
                    </div>
                </div>

            <div class="form-group">
                    <h3>So sánh tướng</h3>

                    <div id="template_character" style="display: none">
                        <div>
                            <label>Chọn Tướng</label>
                            {!! Form::select('character_select_id[]', array('' => 'Chọn Tướng') + App\Character::pluck('title', 'id')->all(), null) !!}

                            <label>Loại</label>

                            {!! Form::select('character_select_manh_hon[]', array('' => 'Chọn loại') + config('character'), null) !!}

                            {!! Form::textarea('character_select_desc[]', null, ['class' => 'form-control']) !!}

                            <input type="button" class="btn-danger delete-character" value="Xóa"/>
                        </div>
                    </div>


                    <div id="character" class="form-group">
                        @if ($content->characters->count() > 0)
                            @foreach ($content->characters as $character)
                                <div>

                                    <label>Chọn Tướng</label>
                                    {!! Form::select('character_select_id[]', array('' => 'Chọn Tướng') + App\Character::pluck('title', 'id')->all(), $character->id) !!}

                                    <label>Loại</label>

                                    {!! Form::select('character_select_manh_hon[]', array('' => 'Chọn loại') + config('character'), $character->pivot->manh_hon) !!}

                                    {!! Form::textarea('character_select_desc[]', $character->pivot->desc, ['class' => 'form-control']) !!}

                                    <input type="button" class="btn-danger delete-character" value="Xóa"/>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <button id="add-character" class="btn-success">Thêm</button>
                    </div>
                </div>


             <div class="form-group">
                    <h3>Cách tăng skill tướng</h3>

                    <div id="content_skill">


                    </div>
                </div>

            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            </div>

            {!! Form::close() !!}

            @include('admin.list')

        </div>
    </div>
@endsection

@section('footer')
    <script>


        function showContentSkill() {
            var content_id = $('#store_content_id').val();
            var character_id = $('#choose_character').val();
            if (character_id) {
                $.get('/contentAjax?content_id=' + content_id + '&character_id=' + character_id, function(res){
                    $('#content_skill').html(res);
                });
            } else {
                $('#content_skill').html('');
            }
        }

        $(function () {

            showContentSkill();

            $('#supplement').on('click', '.delete-supplement', function () {
                $(this).parent().remove();
            });

            $('#add-supplement').click(function () {
                $('#supplement').append($('#template_supplement').html());
                return false;
            });

            $('#equipment').on('click', '.delete-equipment', function () {
                $(this).parent().remove();
            });

            $('#add-equipment').click(function () {
                $('#equipment').append($('#template_equipment').html());
                return false;
            });

            $('#support').on('click', '.delete-support', function () {
                $(this).parent().remove();
            });

            $('#add-support').click(function () {
                $('#support').append($('#template_support').html());
                return false;
            });

            $('#character').on('click', '.delete-character', function () {
                $(this).parent().remove();
            });

            $('#add-character').click(function () {
                $('#character').append($('#template_character').html());
                return false;
            });

            $('#choose_character').change(function(){
                showContentSkill();
            });

            $('#content_skill').on('change', 'input:checkbox', function(){
                var check_class = $(this).attr('class');
                if ($(this).is(":checked")) {
                    $('#content_skill input:checkbox[class='+check_class+']').not(this).prop('checked', false).prop('disabled', true);
                } else {
                    $('#content_skill input:checkbox[class='+check_class+']').not(this).prop('disabled', false);
                }
            });

        });
    </script>
@endsection