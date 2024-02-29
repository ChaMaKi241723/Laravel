@extends('layout')

@section('content')
    <h1>{{ $shop->name }}</h1>

    <div>
        <p>{{ $shop->category->name }}</p>
        <p>{{ $shop->address }}</p>
    </div>

    <iframe
     id='map' src='https://www.google.com/maps/embed/v1/place?key=AIzaSyAGIwN0M9CdCz7YRtIy5_BquSccFkcpzgA&q={{ $shop->address }}'
     width='40%'
     height='350'
     frameborder='0'
    >
    </iframe>

    <p>
        @php
            var_dump($reviews);
        @endphp
    </p>

    <h3>口コミ一覧</h3>
    <table class='table table-striped table-hover'>
        <tr>
            <th>本文</th><th>投稿者</th>
        </tr>
        @if($reviews)
            <tr><td>まだ口コミがありません！</td></tr>
        @endif

        @foreach($reviews as $review)
            <tr>
                <td>
                    {{ $review->text }}
                </td>
                <td>
                    {{ $review->user->name }}
                </td>
            </tr>
        @endforeach
       
    </table>
    <p><a href={{ route('shop.createReview', ['id' => $shop->id]) }}>口コミ投稿</a></p>
    
    <div>
        <p>
            <a href={{ route('shop.list') }}>一覧に戻る</a>
            @auth
                <!--店舗情報作成者とログイン中ユーザが同一人物なら編集・削除フォームを表示-->
                @if($shop->user_id === $login_user_id)
                    | <a href={{ route('shop.edit', ['id' => $shop->id]) }}>編集</a>
                    <p></p>
                    {{ Form::open(['method' => 'delete', 'route' => ['shop.destroy', $shop->id]]) }}
                    {{ Form::submit('削除') }}
                    {{ Form::close() }}
                @endif
            @endauth
        </p>
    </div>
@endsection
