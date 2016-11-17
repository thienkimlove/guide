@extends('frontend.template')

@section('content')
    <div class="page-guide-detail">
        <div class="guide-title text-center">
            <h1>{{$guide->position->frontend_name}}</h1>
            <div class="champ-icon">
                <img src="{{url('img/cache/220x220', $guide->character->image)}}"/>
                <p>{{$guide->character->title}}</p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="chitietcachchoi">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified ggnav" role="tablist">
                <li role="presentation" class="active"><a href="#botro" aria-controls="botro" role="tab" data-toggle="tab">Bổ trợ</a></li>
                <li role="presentation"><a href="#cachchoi" aria-controls="cachchoi" role="tab" data-toggle="tab">Cách chơi</a></li>
                <li role="presentation"><a href="#uunhuoc" aria-controls="uunhuoc" role="tab" data-toggle="tab">Ưu/nhược</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="botro">
                    <div class="bbt">
                        <h2>Bảng bổ trợ</h2>
                        <div class="text-center"><img src="{{url('img/cache/645x385', $guide->table_support_1)}}"/></div>
                    </div>
                    <div class="nbt">
                        <h2>Ngọc bổ trợ</h2>
                        <ul>
                            @foreach ($guide->supplements as $supplement)
                            <li><img src="{{url('img/cache/80x88', $supplement->image)}}"/> <span>x{{$supplement->pivot->number}} {{$supplement->name}} </span></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="pbt ">
                        <h2>Phép bổ trợ</h2>
                        <div class="block block40 block-push-10 text-center">
                            <p>Bổ trợ chính</p>
                            @foreach ($guide->supports as $support)
                                @if ($support->pivot->type == 'chinh')
                                    <div class="block30 block-push-10">
                                        <img src="{{url('img/cache/91x91', $support->image)}}"/>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="block block40 block-push-10 text-center">
                            <p>Bổ trợ tình huống</p>
                            @foreach ($guide->supports as $support)
                                @if ($support->pivot->type == 'tinh_huong')
                                    <div class="block30 block-push-10">
                                        <img src="{{url('img/cache/91x91', $support->image)}}"/>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="cachchoi">
                    <div class="cckn">
                        <h2>Cách cộng kỹ năng</h2>
                        <div class="text-center">
                            <table class="table-bordered table-responsive">
                                <thead>
                                <th>Skill</th>
                                @for ($i = 1; $i < 19; $i ++)
                                    <th>Level {{$i}}</th>
                                @endfor
                                </thead>
                                <tbody>

                                @foreach ($guide->character->skills as $skill)
                                    <tr>
                                        <td><img src="{{url('img/cache/small', $skill->image)}}"/></td>

                                        @for ($i = 1; $i < 19; $i ++)
                                            <td style="align-content: center">
                                               {{($guide->skills()->where('skill_id', $skill->id)->where('step', 'like', '%'.$i.',%')->count() > 0) ? 'v' : 'x'}}
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tbtc">
                        <h2>Trang bị tùy chọn</h2>
                        <div class="text-center">
                            <div class="itemnho">
                                <p>Trang bị hoàn chỉnh </p>
                                <ul class="list-trangbi">
                                    @foreach ($guide->equipments as $equipment)
                                        @if ($equipment->pivot->type == 'hoan_chinh')
                                           <li><img src="{{url('img/cache/103x103', $equipment->image)}}"/></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                            <div class="itemnho">
                                <p>Trang bị khởi đầu</p>
                                <ul class="list-trangbi">
                                    @foreach ($guide->equipments as $equipment)
                                        @if ($equipment->pivot->type == 'khoi_dau')
                                            <li><img src="{{url('img/cache/103x103', $equipment->image)}}"/></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="itemnho">
                                <p>Trang bị giữa trận</p>
                                <ul class="list-trangbi">
                                    @foreach ($guide->equipments as $equipment)
                                        @if ($equipment->pivot->type == 'giua_tran')
                                            <li><img src="{{url('img/cache/103x103', $equipment->image)}}"/></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="itemnho">
                                <p>Trang bị tùy chọn</p>
                                <ul class="list-trangbi">
                                    @foreach ($guide->equipments as $equipment)
                                        @if ($equipment->pivot->type == 'tuy_chon')
                                            <li><img src="{{url('img/cache/103x103', $equipment->image)}}"/></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="gddt">
                        <h2>Giai đoạn đầu trận</h2>
                        <div class="nd">
                           {!! $guide->giai_doan_dau_tran !!}
                        </div>
                    </div>
                    <div class="gdgt ">
                        <h2>Phép bổ trợ</h2>
                        <div class="nd">
                            {!! $guide->giai_doan_giua_tran !!}
                        </div>
                    </div>
                    <div class="gdct ">
                        <h2>Phép bổ trợ</h2>
                        <div class="nd">
                            {!! $guide->giai_doan_cuoi_tran !!}
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="uunhuoc">
                    <div class="uudiem">
                        <h2>Ưu điểm</h2>
                        <div class="nd">
                            {!! $guide->uu_diem !!}
                        </div>
                    </div>
                    <div class="nhuocdiem">
                        <h2>Nhược điểm</h2>
                        <div class="nd">
                            {!! $guide->nhuoc_diem !!}
                        </div>
                    </div>
                    <div class="manhhon">
                        <h2>Mạnh hơn khi đối đầu</h2>
                        <div class="nd">
                            <ul class="stronger-champ">
                                @foreach ($guide->characters as $k => $character)
                                    @if ($character->pivot->manh_hon == 1)
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#myModal{{$k}}"><img src="{{url('img/cache/142x139', $character->image)}}"/></a>
                                            <p>{{$character->title}}</p>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="yeuhon">
                        <h2>Yếu hơn khi đối đầu</h2>
                        <div class="nd">
                            <ul class="weak-champ">
                                @foreach ($guide->characters as $k => $character)
                                    @if ($character->pivot->manh_hon == 2)
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#myModal{{$k}}"><img src="{{url('img/cache/142x139', $character->image)}}"/></a>
                                            <p>{{$character->title}}</p>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('modal')
    @foreach ($guide->characters as $k => $character)
        <div class="modal fade" id="myModal{{$k}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            <img src="{{url('img/cache/142x139', $character->image)}}"/>
                            {{$character->title}}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{$character->pivot->desc}}</p>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection