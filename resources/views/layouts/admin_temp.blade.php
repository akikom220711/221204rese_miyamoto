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
      @can('admin_only')
        <p class="menu">
          <a href="#menu_admin">
            <img class="menu_img" src="/img/menu_button.png" alt="menu">
          </a>
        </p>
      @endcan
      
      <h1 class="title">Rese for Admin</h1>
    </div>

    @can('admin_only')
      <div id="menu_admin" class="menu_box">
        <p>
          <a href="#" onClick="history.back(-1)">
            <img class="close_img" src="/img/close_button.png" alt="close">
          </a>
        </p>
        <div class="menu_contents">
          <p class="menu_text"><a class="menu_text_a" href="/">Home</a></p>
          <p class="menu_text"><a class="menu_text_a" href="/userlogout">Logout</a></p>
          <p class="menu_text"><a class="menu_text_a" href="/admin">Home for admin</a></p>
        </div>
      </div>
    @endcan

    @yield('content')

  </div>
</body>

</html>