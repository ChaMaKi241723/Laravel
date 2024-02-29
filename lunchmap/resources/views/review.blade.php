@extends('layout')

@section('content')
    <h3>{{ $shop->name }}　口コミ投稿フォーム</h3>

    {{ Form::open(['route' => ['shop.review']]) }}
    <div class='form-group'>
        {{ Form::label('text', '本文') }}
        <br>
        {{ Form::textarea('text', null) }}
    </div>
    <div class='form-group'>
        {{ Form::hidden('id',  $shop->id  ) }}
    </div>
    <div class='form-group'>
        {{ Form::submit('投稿する', ['class' => 'btn btn-outline-primary']) }}
    </div>    

    <p>
        <a href={{ route('shop.list') }}>一覧に戻る</a>
    </p>

@endsection
