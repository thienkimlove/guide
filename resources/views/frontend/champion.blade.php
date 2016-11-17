@extends('frontend.template')

@section('content')
    @include('frontend.champion_detail')
@endsection

@section('modal')
    @foreach ($character->skills as $k => $skill)
      <div class="modal fade" id="myModal{{$k}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        <img src="{{url('img/cache/124x145', $skill->image)}}"/>
                        {{$skill->name}}</h4>
                </div>
                <div class="modal-body">
                    <p>{{$skill->desc}}</p>
                    <iframe width="560" height="315" src="{{$skill->url}}" frameborder="0" allowfullscreen></iframe>
                </div>

            </div>
        </div>
    </div>
    @endforeach
@endsection