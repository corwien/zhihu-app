@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $question->title }}
                        @foreach($question->topics as $topic)
                            <a class="topic pull-right" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                        @endforeach
                    </div>

                    <div class="panel-body content">
                        {!! $question->body !!}
                    </div>

                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/questions/{{ $question->id }}/edit">编辑</a></span>

                            <form action="/questions/{{ $question->id }}" method="post">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="is-naked delete-form delete-button" type="submit">删除</button>
                            </form>
                        @endif

                        <!-- question评论Vue -->
                        <comments
                                type="question"
                                model="{{ $question->id }}"
                                count="{{ $question->comments()->count() }}">

                        </comments>

                    </div>


                </div>
            </div>
            @include("layouts._right_question_follow_side")
            @include("layouts._right_question_author_side")
        </div>
        @include("answers._create")

    </div>
@endsection
