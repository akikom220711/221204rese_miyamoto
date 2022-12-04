@extends('layouts.manage_temp')

@section('title')
店舗登録完了
@endsection

@section('content')
<div class="thanks_box">
  <p class="thanks_text">店舗を登録しました。</p>
  <button class="thanks_button" onclick="location.href='/manage'">戻る</button>
</div>
@endsection