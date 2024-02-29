@extends('layout')

@section('content')
    <h1>商品一覧</h1>
    @foreach($products as $product)
        <p>
            <a href={{ route('product.detail', ['id'=>$product->id]) }}>{{ $product->name }}</a>　
            {{ $product->price }}円
        </p>
    @endforeach

    <p>
        <a href={{ route('shop.cart') }}>カートを見る</a>
    </p>
@endsection
