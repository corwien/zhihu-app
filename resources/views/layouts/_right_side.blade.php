<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading question-follow">
            <h2>{{ $question->followers_count }}</h2>
            <span>关注者</span>
        </div>
        <div class="panel-body">
            {{--
            <a href="/questions/{{ $question->id }}/follow" class="btn btn-default {{ Auth::user()->followed($question->id) ? 'btn-success' : ''}}">
                {{ Auth::user()->followed($question->id) ? '已关注' : '关注该问题'}}
            </a>
             --}}
            <question-follow-button  question="{{ $question->id }}" user="{{ Auth::id() }}"></question-follow-button>
            {{--<example></example>--}}
            <a href="#editor" class="btn btn-primary">撰写答案</a>
        </div>
    </div>

</div>
