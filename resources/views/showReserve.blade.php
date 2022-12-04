@extends('layouts.manage_temp')

@section('title')
予約一覧
@endsection

@section('content')
<div class="mypage_reserve_box">
  <h2 class="mypage_title">　{{ $shop -> shop_name}}　予約状況</h2>

  <?php $counter = 0;?>
  @foreach ($reserves as $reserve)
      <?php $counter++;?>
      <div class="mypage_reserve_card">
        <table>
          <tr>
            <th class="mypage_reserve_th">
              <img class="clock_img" src="/img/reserve.png" alt="予約">　予約{{$counter}}
            </th>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th class="mypage_reserve_th">Name</th>
            <td class="mypage_reserve_td">{{$reserve -> user -> name}}　様</td>
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
            <td></td>
          </tr>
        </table>
      </div>
  @endforeach

  @if($counter == 0)
    <p>　　　予約はありません。</p>
  @endif
</div>

@endsection