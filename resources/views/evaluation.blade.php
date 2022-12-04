@extends('layouts.template')

@section('title')
ご利用ありがとうございました。
@endsection

@section('content')

@if(Auth::check())
<div class="evaluation_all">
  <h2 class="evaluation_title">ご利用ありがとうございました。</h2>

  <form>
    @csrf
    <table class="evaluation_table">
      <tr>
        <th class="evaluation_th">評価：</th>
        <td class="evaluation_td">
          <label><input class="evaluation_radio" type="radio" name="evaluation" value="1">1</label>
          <label><input class="evaluation_radio" type="radio" name="evaluation" value="2">2</label>
          <label><input class="evaluation_radio" type="radio" name="evaluation" value="3">3</label>
          <label><input class="evaluation_radio" type="radio" name="evaluation" value="4">4</label>
          <label><input class="evaluation_radio" type="radio" name="evaluation" value="5">5</label>
        </td>
      </tr>
      <tr>
        <th class="evaluation_th">コメント：</th>
        <td class="evaluation_td">
          <textarea class="evaluation_text" name="evaluation_comment"></textarea>
        </td>
      </tr>
    </table>
    <input class="evaluation_btn" type="submit" value="評価する" formaction="/evaluation/{{ $reserve_id }}" formmethod="POST">
    <input class="evaluation_btn" type="submit" value="評価しない" formaction="/deleteReserve/{{ $reserve_id }}" formmethod="GET">
  </form>

</div>

@endif

@endsection