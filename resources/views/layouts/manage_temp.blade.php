<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <title>@yield('title')</title>
</head>

<body>
  <div class="all">
    <div class="menu_bar">
      @if(Auth::guard('managers')->check())
        <p class="menu">
          <a href="#menu_registed_manager">
            <img class="menu_img" src="/img/menu_button.png" alt="menu">
          </a>
        </p>
      @else
        <p class="menu">
          <a href="#menu_unregisted_user">
            <img class="menu_img" src="/img/menu_button.png" alt="menu">
          </a>
        </p>
      @endif
      
      <h1 class="title">Rese for Manager</h1>
    </div>

    @if(Auth::guard('managers')->check())
      <div id="menu_registed_manager" class="menu_box">
        <p>
          <a href="#" onClick="history.back(-1)">
            <img class="close_img" src="/img/close_button.png" alt="close">
          </a>
        </p>
        <div class="menu_contents">
          <p class="menu_text"><a class="menu_text_a" href="/">Home</a></p>
          <p class="menu_text"><a class="menu_text_a" href="/manager/userlogout">Logout</a></p>
          <p class="menu_text"><a class="menu_text_a" href="/manage">Home for manager</a></p>
        </div>
      </div>
    @else
      <div id="menu_unregisted_user" class="menu_box">
        <p>
          <a href="#" onClick="history.back(-1)">
            <img class="close_img" src="/img/close_button.png" alt="close">
          </a>
        </p>
        <div class="menu_contents">
          <p class="menu_text"><a class="menu_text_a" href="/">Home</a></p>
          <p class="menu_text"><a class="menu_text_a" href="/regist">Registration</a></p>
          <p class="menu_text"><a class="menu_text_a" href="/userlogin">Login</a></p>
        </div>
      </div>
    @endif

    @yield('content')

  </div>
</body>

</html>