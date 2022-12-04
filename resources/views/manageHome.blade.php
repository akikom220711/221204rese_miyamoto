@extends('layouts.manage_temp')

@section('title')
店舗代表者用ページ
@endsection

@section('content')
@if(Auth::guard('managers')->check())
<div>
  <div >
    <button class="create_shop_button" onclick="location.href='/createShop'">店舗情報作成</button>
  </div>

  <div class="shop_list">
    <h2 class="shop_list_title">登録店舗一覧</h2>
    @foreach ($shops as $shop)
    <div class="manage_shop_card">
      <p class="manage_shop_name">{{ $shop -> shop_name }}</p>
      <button class="manage_button" onclick="location.href='/goToUpdateShop/{{ $manager->id }}/{{ $shop->id }}'">更新</button>
      <button class="manage_button" onclick="location.href='/showReserve/{{ $shop->id }}'">予約一覧</button>
    </div>
    @endforeach
  </div>

  <div class="shop_list">
    <h2 class="shop_list_title">メール送信</h2>
    <form action="/sendMailForUser" method="POST">
      @csrf
      <table class="email_table">
        <tr>
          <th rowspan="2" class="email_th">件名：</th>
          <td><input class="email_title" type="text" name="title" value="{{old('title')}}"></td>
        </tr>
        <tr>
          <td><p class="validation_error">
              @if ($errors->has('title'))
                {{ $errors->first('title')}}
              @endif
            </p></td>
        </tr>

        <tr>
          <th rowspan="2" class="email_th">e-mail：</th>
          <td>
            <select name="mail_address" class="email_address">
              @foreach ($users as $user)
                @if(old('mail_address') == $user->email)
                  <option value="{{ $user->email }}" selected>{{ $user->name}}様　{{$user->email}}</option>
                @else
                  <option value="{{ $user->email }}">{{ $user->name}}様　{{$user->email}}</option>
                @endif
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <td><p class="validation_error">
              @if ($errors->has('mail_address'))
                {{ $errors->first('mail_address')}}
              @endif
            </p></td>
        </tr>

        <tr>
          <th rowspan="2" class="email_th">本文：</th>
          <td><textarea class="email_text" name="mail_text">{{old('mail_text')}}</textarea></td>
        </tr>
        <tr>
          <td><p class="validation_error">
              @if ($errors->has('mail_text'))
                {{ $errors->first('mail_text')}}
              @endif
            </p></td>
        </tr>
      </table>
      
      <input class="email_btn" type="submit" value="送信">
    </form>
  </div>

</div>
@endif

@endsection