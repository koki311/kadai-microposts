@extends('layouts.app') 

@section('content')
    <div class="center jumbotron">
        <dix class="text-center">
            <h1>Wellcome to the Microposts</h1>
             {{-- ユーザ登録ページへのリンク --}}
            {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
        </dix>
    </div>
@endsection