@extends('layout')

@section('content')
    @if(session('errorMessage'))
        <div class="alert alert-success text-center">
            {{ session('errorMessage') }}
        </div>
    @endif

    <h1>商品詳細</h1>
    <div>
        {{ Form::open(['route' => ['shop.cartin']]) }}
        <div class='form-group'>
            {{ Form::label('text', '商品コード：') }}
            {{ Form::hidden('code', $product->id) }}
        </div>
        <div class='form-group'>
            {{ Form::label('text', '商品名　　：') }}
            {{ $product->name }}
        </div>
        <div class='form-group'>
            {{ Form::label('text', '価格　　　：') }}
            {{ $product->price }}円
        </div>
        <div class='form-group'>
            {{ Form::label('text', '個数　　　：') }}
            {{ Form::select('qty', [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10]), 1}}
        </div>
        <div class='form-group'>
            {{ Form::submit('カートに入れる', ['class' => 'btn btn-outline-primary']) }}
        </div>    

    </div>

    <div>
        <a href={{ route('product.list') }}>一覧に戻る</a>
    </div>
@endsection
