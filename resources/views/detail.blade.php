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
@can('user_only')
  <div class="reserve_detail">
    <h3 class="detail_reserve_title">予約</h3>

    <form action="/confirm/{{$user->id}}/{{$shop_id}}" method="POST">
      @csrf
      <input class="detail_reserve_date" type="date" name="date" value="{{old('date', date('Y-m-d'))}}">
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


      <input class="reserve_button" type="submit" value="確認する">
    </form>
  </div>

<!--以下ログインなしの場合-->
@else

  <div class="reserve_detail">
    <h3 class="detail_reserve_title">予約</h3>

    <form action="/userlogin" method="get">
      @csrf
      <input class="detail_reserve_date" type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
      <p class="validation_error"></p>
      
      <p><select class="detail_reserve_td" name="time">
        @for ($i = 0; $i < 7; $i++)
          <?php
          $hour = 17 + $i;
          $reserve_time = (string)$hour . ':00' ; ?>
          <option value="{{$reserve_time}}">{{$reserve_time}}</option>
        @endfor
      </select></p>
      <p class="validation_error"></p>
      
      <p><select class="detail_reserve_td" name="number">
        @for ($i=1; $i<=10; $i++)
            <option value="{{$i}}">{{$i}}人</option>
        @endfor
      </select></p>


      <input class="reserve_button" type="submit" value="ログインする">
    </form>
  </div>
@endcan

@endsection