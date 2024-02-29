@extends('layouts.app')

@section('javascript')
<script src="/js/confirm.js"></script>

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        メモ編集
        <form id="delete-form" action="{{ route('destroy') }}" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" value="{{ $edit_memo[0]['id']}}" name="memo_id">
            <i class="fas fa-trash me-3 edit-card-header" onclick="deleteHandle(event);"></i>
        </form>
    </div>
    
    <!--/storeとパスを指定しているとurlを変更した際に変更が手間なので、route関数を用いておく-->
    <form class="card-body my-card-body" action="{{ route('update') }}" method="POST">
        <!--csrf攻撃の予防としてトークンを生成-->
        @csrf
        <input type="hidden" value="{{ $edit_memo[0]['id']}}" name="memo_id">
        <div class="form-group">
            <textarea class="form-control mb-3" name="content" rows="3" placeholder="ここにメモを入力">{{ $edit_memo[0]['content'] }}</textarea>
        </div>

        <!--必須項目チェック(バリデーション)-->
        @error('content')
            <div class="alert alert-danger">メモ内容を入力してください！</div> 
        @enderror

        <!--foreachを使ってタグ一覧を表示-->
        @foreach($tags as $t)
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="checkbox" name="tags[]" id="{{ $t['id'] }}" value="{{ $t['id'] }}" {{ in_array($t['id'], $include_tags) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $t['id'] }}">{{ $t['name'] }}</label>
            </div>
        @endforeach
        <br>

        <input type="text" class="form-control w-50 mb-3" name="new_tag" placeholder="新しいタグを入力">
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>

@endsection
