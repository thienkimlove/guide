<div class="page-champion-detail">
    <div class="block block50 thumb-champ">
        <img src="{{url('img/cache/350x634', $character->image)}}"/>
    </div>
    <div class="block block40">
        <h1>{{$character->title}}</h1>
        <div class="thongso">
            <p>Tỷ lệ thắng</p>
            <p>{{$character->ti_le_thang}}%</p>
        </div>
        <div class="thongso">
            <p>Tỷ lệ thua</p>
            <p>{{$character->ti_le_thua}}%</p>
        </div>
        <div class="thongso">
            <p>Tỷ lệ chọn</p>
            <p>{{$character->ti_le_chon}}%</p>
        </div>
        <div class="thongso">
            <p>Tỷ lệ cấm</p>
            <p>{{$character->ti_le_cam}}%</p>
        </div>
    </div>
    <div class="clearfix"></div>
    <ul class="skill-champ">
        @foreach ($character->skills as $k => $skill)
            <li>
                <a href="#" data-toggle="modal" data-target="#myModal{{$k}}"><img src="{{url('img/cache/129x143', $skill->image)}}"/></a>
            </li>
        @endforeach
    </ul>

    <div class="clearfix"></div>
    <div class="line"></div>
    <div class="camnang camnang-moi">
        <div class="title-camnangmoi"></div>
        <ul class="ds-camnang ds-camnangmoi">

            @foreach ($guides as $guide)
                <li>
                    <a href="{{url($guide->slug.'.html')}}">
                            <span class="cham-cn-img">
                                 <img src="{{url('img/cache/49x47', $guide->image)}}"/>
                             </span>
                        <span class="tit-cn">{{$guide->title}}</span></a>
                </li>
            @endforeach

        </ul>
    </div>
</div>