@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">新規メモ作成</div>
    <!--/storeとパスを指定しているとurlを変更した際に変更が手間なので、route関数を用いておく-->
    <form class="card-body my-card-body" action="{{ route('store') }}" method="POST">
        <!--csrf攻撃の予防としてトークンを生成-->
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" rows="3" placeholder="ここにメモを入力"></textarea>
        </div>
        <br>

        <!--必須項目チェック(バリデーション)-->
        @error('content')
            <div class="alert alert-danger">メモ内容を入力してください！</div> 
        @enderror

        @foreach($tags as $t)
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="checkbox" name="tags[]" id="{{ $t['id'] }}" value="{{ $t['id'] }}">
                <label class="form-check-label" for="{{ $t['id'] }}">{{ $t['name'] }}</label>
            </div>
        @endforeach
        <br>

        <input type="text" class="form-control w-50 mb-3" name="new_tag" placeholder="新しいタグを入力">
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>

@endsection
