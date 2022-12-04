@extends('layouts.template')

@section('title')
会員登録
@endsection

@section('content')

<div class="contents_box">
  <h1 class="regist_title">Registration</h1>
  <form action="/regist" method="POST">
    @csrf
    <table class="regist_table">
      <tr>
        <td rowspan="2"><img class="regist_img" src="/img/user.png" alt="イラスト"></td>
        <td class="regist_textbox_line"><input class="regist_textbox" type="text" name="name" placeholder="Username" value="{{old('name')}}"></td>       
      </tr>
      <tr>
        <td class="validation_error">
          @if ($errors->has('name'))
          {{ $errors->first('name')}}
          @endif
        </td>
      </tr>
      <tr>
        <td rowspan="2"><img class="regist_img" src="/img/email.png" alt="イラスト"></td>
        <td class="regist_textbox_line"><input class="regist_textbox" type="text" name="email" placeholder="Email" value="{{old('email')}}"></td>
      </tr>
      <tr>
        <td class="validation_error">
          @if ($errors->has('email'))
          {{ $errors->first('email')}}
          @endif
        </td>
      </tr>
      <tr>
        <td rowspan="2"><img class="regist_img" src="/img/password.png" alt="イラスト"></td>
        <td class="regist_textbox_line"><input class="regist_textbox" type="password" name="password" placeholder="Password"></td>
      </tr>
      <tr>
        <td class="validation_error">
          @if ($errors->has('password'))
          {{ $errors->first('password')}}
          @endif
        </td>
      </tr>
    </table>
    <input class="regist_button" type="submit" value="登録">
  </form>
</div>

@endsection