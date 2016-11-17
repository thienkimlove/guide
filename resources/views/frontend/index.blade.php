@extends('frontend.template')

@section('content')
    <div class="line"></div>
    <div class="vitri">
        <div class="title-vitri"></div>
        <ul class="cacvitri">
            <li>
                <a href="{{url('jungle')}}">
                    <div class="loaivitri vtjung"></div>
                    <p>ĐI RỪNG </p>
                </a>
            </li>
            <li>
                <a href="{{url('ad')}}">
                    <div class="loaivitri vtbot"></div>
                    <p>ĐƯỜNG DƯỚI </p>
                </a>
            </li>
            <li>
                <a href="{{url('support')}}">
                    <div class="loaivitri vtsupport"></div>
                    <p>HỖ TRỢ </p>
                </a>
            </li>

        </ul>
        <div class="cacvitri2">
            <ul class="cacvitri">
                <li>
                    <a href="{{url('top')}}">
                        <div class="loaivitri vttop"></div>
                        <p><a href="#">ĐƯỜNG TRÊN</a> </p>
                    </a>
                </li>
                <li>
                    <a href="{{url('mid')}}">
                        <div class="loaivitri vtmid"></div>
                        <p><a href="#">ĐƯỜNG GIỮA</a> </p>
                    </a>
                </li>
            </ul>
        </div>

    </div>
    <div class="clearfix"></div>
    <div class="line"></div>

    <div class="camnang camnang-moi">
        <h2 class="title"><img src="{{url('frontend/img/book-cnm.png')}}"/> Cẩm nang mới</h2>
        <ul class="ds-camnang-moi">
            @foreach ($latestGuides as $guide)
              <li>
                <a href="{{url($guide->slug.'.html')}}">
                    <span class="cham-cn-img">
                        <img src="{{url('img/cache/60x60', $guide->image)}}"/>
                    </span>
                    <span class="tit-cn">{{$guide->title}}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="camnang-hot">
        <h2 class="title"><img src="{{url('frontend/img/book-cnh.png')}}"/> Cẩm nang hot</h2>
        <ul class="ds-camnang-hot">
            @foreach ($hotGuides as $guide)
                <li>
                    <a href="{{url($guide->slug.'.html')}}">
                    <span class="cham-cn-img">
                        <img src="{{url('img/cache/60x60', $guide->image)}}"/>
                    </span>
                        <span class="tit-cn">{{$guide->title}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection