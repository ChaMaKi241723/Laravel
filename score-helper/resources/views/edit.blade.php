@extends('layouts.app')

@section('javascript')
<script src="/js/confirm.js"></script>

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        成績編集
        <form id="delete-form" action="{{ route('destroy') }}" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" value="{{ $edit_score[0]['id']}}" name="score_id">
            <button type="submit">削除</button>
        </form>
    </div>
    
    <!--/storeとパスを指定しているとurlを変更した際に変更が手間なので、route関数を用いておく-->
    <form class="card-body my-card-body" action="{{ route('update') }}" method="POST">
        <!--csrf攻撃の予防としてトークンを生成-->
        @csrf
        <div class="form-group">
            <input type="hidden" value="{{ $edit_score[0]['id']}}" name="score_id">

            生徒氏名を選択してください<br>
            <select class="form-group" name="student_id" value="{{ $edit_score[0]['student_id'] }}">
                @foreach($students as $s)
                        <option class="form-group-item" name="student_id" id="{{ $s['id'] }}" value="{{ $s['id'] }}">
                        <label class="form-check-label" for="{{ $s['id'] }}">{{ $s['name'] }}</label>
                @endforeach
            </select>
            <br>

            科目を選択してください<br>
            <select class="form-group" name="subject_id">
                @foreach($subjects as $s)
                        <option class="form-group-item" name="subject_id" id="{{ $s['id'] }}" value="{{ $edit_score[0]['subject_id'] }}">
                        <label class="form-check-label" for="{{ $s['id'] }}">{{ $s['name'] }}</label>
                @endforeach
            </select>
            <br>

            点数を入力してください<br>
            <input type="number" min="0" max="100" name="score" value="{{ $edit_score[0]['score'] }}"><br><br>
            <textarea class="form-control" name="comment" rows="3" placeholder="ここにコメントを入力">{{ $edit_score[0]['comment'] }}</textarea><br>
        </div>

        <!--必須項目チェック(バリデーション)-->
        @error('score')
            <div class="alert alert-danger">点数を入力してください！</div> 
        @enderror

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>

@endsection
