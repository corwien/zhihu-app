<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading question-follow">
            <h5>关于作者</h5>
        </div>
        <div class="panel-body">
           <div class="media">
               <div class="media-left">
                   <a href="#">
                       <img width="36px;" src="{{$question->user->avatar}}" alt="{{ $question->user->name }}">
                   </a>
               </div>
               <div class="media-body">
                   <h4 class="media-heading">
                       <a href="#">
                           {{ $question->user->name }}
                       </a>
                   </h4>
               </div>
               <div class="user-statics">
                   <div class="statics-item text-center">
                       <div class="statics-text">问题</div>
                       <div class="statics-count">{{ $question->user->questions_count }}</div>
                   </div>
                   <div class="statics-item text-center">
                       <div class="statics-text">回答</div>
                       <div class="statics-count">{{ $question->user->answers_count }}</div>
                   </div>
                   <div class="statics-item text-center">
                       <div class="statics-text">关注者</div>
                       <div class="statics-count">{{ $question->user->followers_count }}</div>
                   </div>
               </div>

           </div>
            <user-follow-button user="{{ $question->user_id }}"></user-follow-button>
            <send-message user="{{ $question->user_id }}"></send-message>
        </div>
    </div>
</div>
