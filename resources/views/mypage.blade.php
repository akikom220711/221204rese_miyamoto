@extends('layouts.template')

@section('title')
マイページ
@endsection

@section('content')

@if(Auth::check())
<h1 class="mypage_name">{{ $user -> name }}さん</h1>

<div class="mypage_reserve_box">
  <h2 class="mypage_title">予約状況</h2>

  <?php $counter = 0;?>
  @foreach ($reserves as $reserve)
    @if ($reserve->user_id == $user->id)
      <?php $counter++;?>
      <div class="mypage_reserve_card">
        <table>
          <tr>
            <th class="mypage_reserve_th">
              <img class="clock_img" src="/img/reserve.png" alt="予約">　予約{{$counter}}
            </th>
            <td></td>
            <td class="close_btn_td">
              <a href="/evaluation/{{$reserve -> id}}">
                <img class="close_button" src="/img/close_white.png" alt="削除">
              </a>
            </td>
          </tr>
          <tr>
            <th class="mypage_reserve_th">Shop</th>
            <td class="mypage_reserve_td">{{$reserve -> shop -> shop_name}}</td>
            <td></td>
          </tr>
          <tr>
            <th class="mypage_reserve_th">Date</th>
            <td class="mypage_reserve_td">{{$reserve -> date}}</td>
            <td></td>
          </tr>
          <tr>
            <th class="mypage_reserve_th">Time</th>
            <td class="mypage_reserve_td">{{ substr($reserve -> time, 0, 5) }}</td>
            <td></td>
          </tr>
          <tr>
            <th class="mypage_reserve_th">Number</th>
            <td class="mypage_reserve_td">{{$reserve -> number}}人</td>
            <td>
              <?php $text = "Name ".$reserve->user->name." Date ".$reserve->date." Time ".$reserve->time." Number ".$reserve->number."人";
              echo QrCode::encoding('UTF-8')->size(50)->generate($text); ?>
            </td>
          </tr>
          <tr>
            <th class="mypage_reserve_th">
              <button class="change_btn" onclick="location.href='/goToChangeReserve/{{ $reserve->id }}'">変更</button>
            </th>
            <td class="mypage_reserve_td">
              <form action="/payment" method="POST">
                @csrf
                <script
                  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                  data-key="{{ env('STRIPE_KEY') }}"
                  data-amount="2000"
                  data-name="お支払い画面"
                  data-label="お支払い"
                  data-locale="auto"
                  data-currency="JPY"
                ></script>
              </form>
            </td>
            <td></td>
          </tr>
        </table>
        

        


      </div>
    @endif
  @endforeach
</div>

<div class="mypage_favorite_box">
  <h2 class="mypage_title">お気に入り店舗</h2>

  @foreach ($favorites as $favorite)
    @if ($favorite->user_id == $user->id)
      <div class="shop_card">
        <img class="shop_image" src="{{ $favorite -> shop -> url }}" alt="写真">
        <p class="shop_name">{{ $favorite -> shop -> shop_name }}</p>
        <p class="shop_area">#{{ $favorite -> shop -> region -> region }}</p>
        <p class="shop_genre">#{{ $favorite -> shop -> category -> category }}</p>
        <img class="evaluation_img" src="img/evaluation.png" alt="評価：">
    <p class="evaluation_ave">{{ $evaluation_ave[$favorite->shop_id] }}（{{ $evaluation_n[$favorite->shop_id] }}）</p>
        <div class="detail_box">
          <form action="{{ route('detail', $favorite -> shop_id) }}" method="GET">
            <input class="detail_button" type="submit" value="詳しく見る">
          </form>
          <a href="/deleteFavorite/{{ $user -> id }}/{{ $favorite -> shop_id }}"><img class="favorite_img" src="img/heart_red.png" alt="〇"></a>
        </div>
      </div>

    @endif
  @endforeach
</div>


@endif

@endsection