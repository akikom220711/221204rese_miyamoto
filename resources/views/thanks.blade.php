@extends('layouts.template')

@section('title')
登録完了
@endsection

@section('content')
<div class="thanks_box">
  <p class="thanks_text">会員登録ありがとうございます。</p>
  <button class="thanks_button" onclick="location.href='/userlogin'">ログインする</button>
</div>
@endsection