

            @foreach($question->answers as $answers)
                <div class="media">
                    <div class="media-left">
                        <a href="">
                            <img width="36px" src="{{ $answers->user->avatar }}" alt="{{ $answers->user->name }}">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="/user/{{ $answers->user->id }}">{{ $answers->user->name }}</a>
                        </h4>

                        {!! $answers->body !!}
                    </div>
                </div>
            @endforeach

