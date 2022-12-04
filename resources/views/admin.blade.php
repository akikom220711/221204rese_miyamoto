@extends('layouts.admin_temp')

@section('title')
管理者用ページ
@endsection

@section('content')
<div>
  <div class="admin_title">
    <h2 class="admin_title_txt">店舗代表者登録</h2>
    <form action="/admin" method="POST">
      @csrf
      <table class="manager_regist_table">
        <tr>
          <th class="manager_regist_th" rowspan="2">代表者名：</th>
          <td><input type="text" name="manager_name" placeholder="name" value="{{old('manager_name')}}"></td>
        </tr>
        <tr>
          <td><p class="validation_error">
            @if ($errors->has('manager_name'))
              {{ $errors->first('manager_name')}}
            @endif
          </p></td>
        </tr>
        <tr>
          <th class="manager_regist_th" rowspan="2">メール：</th>
          <td><input type="email" name="manager_email" placeholder="email" value="{{old('manager_email')}}"></td>
        </tr>
        <tr>
          <td><p class="validation_error">
            @if ($errors->has('manager_email'))
              {{ $errors->first('manager_email')}}
            @endif
          </p></td>
        </tr>
        <tr>
          <th class="manager_regist_th" rowspan="2">パスワード：</th>
          <td><input type="password" name="manager_password" placeholder="password"></td>
        </tr>
        <tr>
          <td><p class="validation_error">
            @if ($errors->has('manager_password'))
              {{ $errors->first('manager_password')}}
            @endif
          </p></td>
        </tr>
      </table>
      <input class="manager_regist_button" type="submit" value="登録">
    </form>
  </div>

  <div class="admin_title">
    <h2 class="admin_title_txt">メール送信</h2>

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

@endsection