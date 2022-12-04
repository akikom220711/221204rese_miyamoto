@extends('layouts.template')

@section('title')
{{ $shops[$shop_id-1] -> shop_name }}
@endsection

@section('content')

<div class="shop_detail">
  <a href="#" onClick="history.back(-1)"><img class="back_button" src="/img/back_button.png" alt="戻る"></a>
  <h2 class="detail_shop_name">{{ $shops[$shop_id-1] -> shop_name }}</h2>
  <img class="detail_shop_img" src="{{ $shops[$shop_id-1] -> url }}" alt="写真">
  <p class="detail_tag">#{{ $shops[$shop_id-1] -> region -> region }}</p>
  <p class="detail_tag">#{{ $shops[$shop_id-1] -> category -> category }}</p>
  <p class="detail_comment">{{ $shops[$shop_id-1] -> comment }}</p>

</div>

<!--以下ログインありの場合-->
@if(Auth::check())
  <div class="reserve_detail">
    <h3 class="detail_reserve_title">予約</h3>

    <form action="/reserve/{{$user_id}}/{{$shop_id}}" method="GET">
      @csrf
      <input class="detail_reserve_date" type="disabled" name="date" value="{{$form['date']}}">
      <p class="validation_error">
      </p>
      <p><select class="detail_reserve_td" name="time">
        <option value="{{ $form['time'] }}" selected disabled>{{ $form['time'] }}</option>
      </select></p>
      <p class="validation_error">
      </p>
      <p><select class="detail_reserve_td" name="number">
        <option value="{{ $form['number'] }}" selected disabled>{{ $form['number'] }}人</option>
      </select></p>
      <p class="validation_error">
      </p>

      <div class="confirm_box">
        <table>
          <tr>
            <th class="confirm_th">Shop</th>
            <td class="confirm_td">{{$shops[$shop_id-1] -> shop_name}}</td>
          </tr>
          <tr>
            <th class="confirm_th">Date</th>
            <td class="confirm_td">{{$form['date']}}</td>
          </tr>
          <tr>
            <th class="confirm_th">Time</th>
            <td class="confirm_td">{{$form['time']}}</td>
          </tr>
          <tr>
            <th class="confirm_th">Number</th>
            <td class="confirm_td">{{$form['number']}}人</td>
          </tr>
        </table>
      </div>

      <p class="confirm_back_cover"><a href="#" onClick="history.back(-1)"><img class="confirm_back_btn" src="/img/back_button.png" alt="戻る"></a></p>

      <input class="reserve_button" type="submit" value="予約する">
    </form>
  </div>

@endif

@endsection