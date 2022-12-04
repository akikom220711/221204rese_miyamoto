@extends('layouts.template')

@section('title')
ログイン
@endsection

@section('content')

<div class="contents_box">
  <h1 class="regist_title">Login</h1>
  <form action="/userlogin" method="POST">
    @csrf
    <table class="regist_table">
      <tr>
        <td rowspan="2">
          <img class="regist_img" src="/img/email.png" alt="メールアドレス">
        </td>
        <td class="regist_textbox_line">
          @if ($error)
            <input class="regist_textbox" type="text" name="email" placeholder="Email" value="{{$data['email']}}">
          @else
            <input class="regist_textbox" type="text" name="email" placeholder="Email" value="{{old('email')}}">
          @endif
        </td>
      </tr>
      <tr>
        <td class="validation_error">
          @if ($errors->has('email'))
          {{ $errors->first('email')}}
          @endif
        </td>
      </tr>
      <tr>
        <td rowspan="2">
          <img class="regist_img" src="/img/password.png" alt="パスワード">
        </td>
        <td class="regist_textbox_line">
          <input class="regist_textbox" type="password" name="password" placeholder="Password">
        </td>
      </tr>
      <tr>
        <td class="validation_error">
          @if ($errors->has('password'))
          {{ $errors->first('password')}}
          @endif
          {{$error}}
        </td>
      </tr>
    </table>
    <input class="login_button" type="submit" value="ログイン">
  </form>
</div>

<a class="manager_link" href="/manager/userlogin">店舗代表者としてログイン</a>

@endsection