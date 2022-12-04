@extends('layouts.template')

@section('title')
Rese
@endsection

@section('content')

  <div class="search">
    <form  action="/search" method="GET">
      @csrf
      <select class="select_button" name="area">
        <option value="0">All area</option>
        @foreach ($regions as $region)
          <option value="{{ $region -> id }}">{{ $region -> region }}</option>
        @endforeach
      </select>
      <select class="select_button" name="genre">
        <option value="0">All genre</option>
        @foreach ($categories as $category)
          <option value="{{ $category -> id }}">{{ $category -> category }}</option>
        @endforeach
      </select>
      <div class="search_box_wrap">
        <input class="search_box" type="text" name='keyword' placeholder="Search...">
      </div>
    </form>
  </div>

    <!--以下userとしてログインしている場合-->
  @can('user_only')
    @foreach ($shops as $shop)
    <?php $url = $shop->url;
          $url_array = explode('/', $shop->url);
          $file_name = "storage/" . end($url_array);?>
    <div class="shop_card">
      <img class="shop_image" src="{{ asset($file_name) }}" alt="店舗写真">
      <p class="shop_name">{{ $shop -> shop_name }}</p>
      <p class="shop_area">#{{ $shop -> region -> region }}</p>
      <p class="shop_genre">#{{ $shop -> category -> category }}</p>
      <img class="evaluation_img" src="img/evaluation.png" alt="評価：">
      <p class="evaluation_ave">{{ $evaluation_ave[$shop->id] }}({{ $evaluation_n[$shop->id] }})</p>
      <div class="detail_box">
        <form action="{{ route('detail', $shop -> id) }}" method="GET">
          <input class="detail_button" type="submit" value="詳しくみる">
        </form>
        @if($favorites_flag[$shop->id-1] == 1)
          <a href="/deleteFavorite/{{ $user -> id }}/{{ $shop -> id }}"><img class="favorite_img" src="img/heart_red.png" alt="〇"></a>
        @else
          <a href="/favorite/{{ $user -> id }}/{{ $shop -> id }}"><img class="favorite_img" src="img/heart_gray.png" alt="×"></a>
        @endif
      </div>
    </div>
    @endforeach

  <!--以下ログインなしもしくはuser以外のログインの場合-->
  @else

    @foreach ($shops as $shop)
    <?php $url = $shop->url;
          $url_array = explode('/', $shop->url);
          $file_name = "storage/" . end($url_array);?>
    <div class="shop_card">
      <img class="shop_image" src="{{ asset($file_name) }}" alt="店舗写真">
      <p class="shop_name">{{ $shop -> shop_name }}</p>
      <p class="shop_area">#{{ $shop -> region -> region }}</p>
      <p class="shop_genre">#{{ $shop -> category -> category }}</p>
      <img class="evaluation_img" src="img/evaluation.png" alt="評価：">
      <p class="evaluation_ave">{{ $evaluation_ave[$shop->id] }}({{ $evaluation_n[$shop->id] }})</p>
      <form action="{{ route('detail', $shop -> id) }}" method="GET">
        <input class="detail_button" type="submit" value="詳しくみる">
      </form>
    </div>
    @endforeach
  @endcan

@endsection