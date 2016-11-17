<div class="form-group">
    <table class="table-bordered table-responsive">
        <thead>
        <th>Skill</th>
        @for ($i = 1; $i < 19; $i ++)
            <th>Level {{$i}}</th>
        @endfor
        </thead>
        <tbody>

        @foreach ($character->skills as $skill)
            <tr>
                <td><img src="{{url('img/cache/small', $skill->image)}}"/></td>

                @for ($i = 1; $i < 19; $i ++)
                    <td style="align-content: center">
                        {!! Form::checkbox('skill['.$skill->id.']['.$i.']', null, ($content && $content->skills()->where('skill_id', $skill->id)->where('step', 'like', '%'.$i.',%')->count() > 0) ? true : false, ['class' => 'column_'.$i]) !!}
                    </td>

                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>

</div>