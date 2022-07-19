@if (count($microposts) > 0)
    <ul class="list-unstyled">
        @foreach($microposts as $micropost)
            <li class="media">
                {{--　ユーザーのメールアドレスをもとにgravatarを取得して表示 --}}
                <img class="mr-2 rounded" src="{{Gravatar::get($user->email, ['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $user->name }}
                    </div>
                    <div>
                        {{--ユーザー詳細ページへのリンク--}}
                        <p>{!! link_to_route('users.show','View profile',['user'=>$user->id]) !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

@endif