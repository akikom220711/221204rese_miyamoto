@extends('layouts.manage_temp')

@section('title')
店舗情報更新
@endsection

@section('content')
@if(Auth::guard('managers')->check())
<div class="create_shop">
  <h2 class="create_shop_title">店舗情報更新</h2>

  <form action="/updateShop/{{ $shop->id }}" method="POST">
    @csrf
    <table class="create_shop_table">
      <tr>
        <th class="create_shop_th" rowspan="2">店舗名：</th>
        <td class="create_shop_td"><input type="text" name="shop_name" value="{{ old('shop_name', $shop->shop_name) }}"></td>
      </tr>
      <tr>
        <td><p class="validation_error">
            @if ($errors->has('shop_name'))
              {{ $errors->first('shop_name')}}
            @endif
          </p></td>
      </tr>

      <tr>
        <th class="create_shop_th" rowspan="2">詳細情報：</th>
        <td class="create_shop_td_big">
          <textarea class="create_shop_text" name="comment">{{ old('comment', $shop->comment) }}</textarea>
        </td>
      </tr>
      <tr>
        <td><p class="validation_error">
            @if ($errors->has('comment'))
              {{ $errors->first('comment')}}
            @endif
          </p></td>
      </tr>

      <tr>
        <th class="create_shop_th" rowspan="2">画像URL：</th>
        <td class="create_shop_td_big">
          <textarea class="create_shop_text" name="url">{{ old('url',  $shop->url) }}</textarea></td>
      </tr>
      <tr>
        <td><p class="validation_error">
            @if ($errors->has('url'))
              {{ $errors->first('url')}}
            @endif
          </p></td>
      </tr>

      <tr>
        <th class="create_shop_th" rowspan="2">地域：</th>
        <td class="create_shop_td">
          <select name="region_id" class="create_shop_select">
            @foreach ($regions as $region)
              @if (old('region_id', $shop->region_id) == $region->id)
                <option value="{{$region->id}}" selected>{{$region->region}}</option>
              @else
                <option value="{{$region->id}}">{{$region->region}}</option>
              @endif
            @endforeach
          </select></td>
      </tr>
      <tr>
        <td><p class="validation_error">
            @if ($errors->has('region_id'))
              {{ $errors->first('region_id')}}
            @endif
          </p></td>
      </tr>

      <tr>
        <th class="create_shop_th" rowspan="2">ジャンル：</th>
        <td class="create_shop_td">
          <select name="category_id" class="create_shop_select">
            @foreach($categories as $category)
              @if (old('category_id', $shop->category_id) == $category->id)
                <option value="{{$category->id}}" selected>{{$category->category}}</option>
              @else
                <option value="{{$category->id}}">{{$category->category}}</option>
              @endif
            @endforeach
          </select></td>
      </tr>
      <tr>
        <td><p class="validation_error">
            @if ($errors->has('category_id'))
              {{ $errors->first('category_id')}}
            @endif
          </p></td>
      </tr>
    </table>
    <input class="create_button" type="submit" value="更新">
  </form>
</div>
@endif

@endsection