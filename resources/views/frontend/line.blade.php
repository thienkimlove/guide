@extends('frontend.template')

@section('content')
    <div class="page-duongduoi">
        <h1 class="title">{{$position->frontend_name}}</h1>
        <ul class="ds-champion">
            @foreach ($characters as $character)
            <li>
                <a href="{{url('champion', $character->slug)}}">
                    <div class="champion">
                        <img src="{{url('img/cache/183x183',  $character->image)}}"/>
                    </div>
                    <p>{{ $character->title}}</p>
                </a>
            </li>
           @endforeach
        </ul>

        <div class="clearfix"></div>
        <div class="line"></div>
        <div class="camnang camnang-bot">
            <h2 class="title"><img src="{{url('frontend/img/book-cnm.png')}}"/>Cẩm nang {{$position->frontend_name}}</h2>
            <ul class="ds-camnang ds-camnang-bot">
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
@endsection