

            @foreach($question->answers as $answers)
                <div class="media">
                    <div class="media-left">
                        <user-vote-button answer="{{ $answers->id }}" count="{{ $answers->votes_count }}"></user-vote-button>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="/user/{{ $answers->user->id }}">{{ $answers->user->name }}</a>
                        </h4>

                        {!! $answers->body !!}
                    </div>

                </div>
            @endforeach

