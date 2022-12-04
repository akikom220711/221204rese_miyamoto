@extends('layouts.template')

@section('title')
予約変更ページ
@endsection

@section('content')

<div class="shop_detail">
  <a href="#" onClick="history.back(-1)"><img class="back_button" src="/img/back_button.png" alt="戻る"></a>
  <h2 class="detail_shop_name">{{ $reserve_data -> shop -> shop_name }}</h2>
  <img class="detail_shop_img" src="{{ $reserve_data -> shop -> url }}" alt="写真">
  <p class="detail_tag">#{{ $reserve_data -> shop -> region -> region }}</p>
  <p class="detail_tag">#{{ $reserve_data -> shop -> category -> category }}</p>
  <p class="detail_comment">{{ $reserve_data -> shop -> comment }}</p>

</div>

<!--以下ログインありの場合-->
@can('user_only')
  <div class="reserve_detail">
    <h3 class="detail_reserve_title">予約</h3>

    <form action="/changeReserve/{{ $reserve_data -> id }}" method="POST">
      @csrf
      <input class="detail_reserve_date" type="date" name="date" value="{{ $reserve_data -> date}}">
      <p class="validation_error">
        @if ($errors->has('date'))
          {{ $errors->first('date')}}
        @endif
      </p>
      <p><select class="detail_reserve_td" name="time">
        @for ($i = 0; $i < 7; $i++)
          <?php
          $hour = 17 + $i;
          $reserve_time = (string)$hour . ':00' ; ?>
          @if(old('time') == $reserve_time)
            <option value="{{$reserve_time}}" selected>{{$reserve_time}}</option>
          @else
            <option value="{{$reserve_time}}">{{$reserve_time}}</option>
          @endif
        @endfor
      </select></p>
      <p class="validation_error">
        @if ($errors->has('time'))
          {{ $errors->first('time')}}
        @endif
      </p>
      <p><select class="detail_reserve_td" name="number">
        @for ($i=1; $i<=10; $i++)
          @if(old('number') == $i)
            <option value="{{$i}}" selected>{{$i}}人</option>
          @else
            <option value="{{$i}}">{{$i}}人</option>
          @endif
        @endfor
      </select></p>
      <p class="validation_error">
        @if ($errors->has('number'))
          {{ $errors->first('number')}}
        @endif
      </p>


      <input class="reserve_button" type="submit" value="変更する">
    </form>
  </div>

@endcan

@endsection