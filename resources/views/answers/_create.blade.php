
@include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">答案数：{{ $question->answers_count }}
                    </div>

                    <div class="panel-body">
                        @include("answers._index")
                        @if(Auth::check())
                                @include("shared.errors")
                                <form action="/questions/{{ $question->id }}/answer" method="post">
                                    {{ csrf_field() }}
                                    <!-- 编辑器容器 -->
                                    <script id="container" name="body" style="height:120px" type="text/plain">
                                        {!! old('body') !!}
                                    </script>
                                    <button class="btn btn-success pull-right" type="submit">提交答案</button>
                                </form>
                        @else
                            <a href="/login" class="btn btn-success  btn-block">登录提交答案</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 实例化编辑器 -->
    @section('js')
        <script type="text/javascript">
            var ue = UE.getEditor('container', {
                toolbars: [
                    ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
                ],
                elementPathEnabled: false,
                enableContextMenu: false,
                autoClearEmptyNode:true,
                wordCount:false,
                imagePopup:false,
                autotypeset:{ indent: true,imageBlockLine: 'center' }
            });
            ue.ready(function() {
                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
            });
        </script>
    @endsection
