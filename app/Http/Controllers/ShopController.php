<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Http\Requests\ReserveRequest;
use App\Models\Category;
use App\Models\Region;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Reserve;
use App\Models\Evaluation;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Stripe\Stripe;
use Stripe\Charge;

class ShopController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $categories = Category::all();
        $regions = Region::all();
        $shops = Shop::all();
        $favorites = Favorite::all();
        $evaluations = Evaluation::all();
        $favorites_flag = [];
        $evaluation_ave = [];
        $evaluation_n = [];

        if($user){
            for($i=0; $i<count($shops); $i++){
                array_push($favorites_flag, 0);
                foreach($favorites as $favorite){
                    if($user->id == $favorite->user_id){
                        if($shops[$i]->id == $favorite->shop_id){
                            $favorites_flag[$i] = 1;
                        }
                    }
                }
            }
        }

        for($i=1; $i<=count($shops); $i++){
            array_push($evaluation_ave, 0);
            array_push($evaluation_n, 0);
            $records = Evaluation::where('shop_id', '=', $i)->get();
            $sum = 0;
            $count = 0;
            foreach($records as $record){
                $sum += $record->evaluation;
                $count++;
            }
            if($count){
                $evaluation_ave[$i] = round($sum/$count, 1);
                $evaluation_n[$i] = $count;
            }else{
                $evaluation_ave[$i] = 0;
                $evaluation_n[$i] = 0;
            }
        }

        foreach($shops as $shop){
            $url = $shop->url;
            $url_array = explode('/', $shop->url);
            $file_name = end($url_array);
            $path = "storage/" . $file_name;
            $file_path = asset($path);
            if(!file_exists($path)){
                try{
                    $image = file_get_contents($url);
                    file_put_contents($path, $image);
                }catch(\Throwable $e){
                }
            }
        }

        $request->session()->put('evaluation_ave', $evaluation_ave);
        $request->session()->put('evaluation_n', $evaluation_n);

        $param = ['user' => $user,
                    'categories' => $categories, 
                    'regions' => $regions, 
                    'shops' => $shops, 
                    'favorites_flag' => $favorites_flag,
                    'evaluation_ave' => $evaluation_ave,
                    'evaluation_n' => $evaluation_n];

        return view('home', $param);
    }

    public function detail($shop_id){
        $user = Auth::user();
        $shops = Shop::all();
        $shops_data = ['user' => $user, 'shops' => $shops, 'shop_id' => $shop_id];

        return view('detail', $shops_data);
    }

    public function favorite($user_id, $shop_id){
            Favorite::create([
                'user_id' => $user_id,
                'shop_id' => $shop_id
            ]);

        return back();
    }

    public function deleteFavorite($user_id, $shop_id){
        Favorite::where('user_id', '=', $user_id)
                    ->where('shop_id', '=', $shop_id)
                    ->delete();

        return back();
    }

    public function confirm(ReserveRequest $request, $user_id, $shop_id){
        $shops = Shop::all();
        $form = $request->all();
        unset($form['_token']);
        $request->session()->put('form', $form);

        $param = ['user_id' => $user_id,
                    'shop_id' => $shop_id,
                    'form' => $form,
                    'shops' => $shops];
        return view('confirm', $param);
    }

    public function reserve(Request $request, $user_id, $shop_id){
        $data = $request->session()->get('form');
        $reserve = ['user_id' => $user_id,
                    'shop_id' => $shop_id,
                    'date' => $data['date'],
                    'time' => $data['time'],
                    'number' => $data['number']];
        Reserve::create($reserve);

        return redirect('/done');
    }

    public function doneReserve(){
        return view('done');
    }

    public function deleteReserve($reserve_id){
        if(Reserve::find($reserve_id)){
            Reserve::find($reserve_id)->delete();
        }
        return redirect('/mypage');
    }

    public function mypage(Request $request){
        $user = Auth::user();
        $reserves = Reserve::all();
        $favorites = Favorite::all();

        $evaluation_ave = $request->session()->get('evaluation_ave');
        $evaluation_n = $request->session()->get('evaluation_n');

        $param = ['user' => $user, 'reserves' => $reserves, 'favorites' => $favorites, 'evaluation_ave' => $evaluation_ave, 'evaluation_n' => $evaluation_n];
        return view('mypage', $param);
    }

    public function goToEvaluation($reserve_id){
        return view('evaluation', ['reserve_id' => $reserve_id]);
    }

    public function evaluation(Request $request, $reserve_id){
        $reserve_data = Reserve::find($reserve_id);
        $evaluation = ['user_id' => $reserve_data['user_id'],
                    'shop_id' => $reserve_data['shop_id'],
                    'evaluation' => $request['evaluation'],
                    'evaluation_comment' => $request['evaluation_comment']];
        Evaluation::create($evaluation);
        return redirect(route('deleteReserve', ['reserve_id' => $reserve_id]));
    }

    public function search(Request $request){
        $user = Auth::user();
        $categories = Category::all();
        $regions = Region::all();
        $favorites = Favorite::all();
        $evaluations = Evaluation::all();
        $shops = Shop::all();
        $favorites_flag = [];
        $evaluation_ave = [];
        $evaluation_n = [];

        $query = Shop::query();
        $form = $request -> all();
        $key_str = $form['keyword'];
        if ($form['area']){
            $query->where('region_id', '=', $form['area']);
        }
        if ($form['genre']){
            $query->where('category_id', '=', $form['genre']);
        }
        if ($form['keyword']){
            $query->where('shop_name', 'LIKE', "%$key_str%");
        }
        $results = $query -> get();

        if($user){
            for($i=0; $i<count($shops); $i++){
                array_push($favorites_flag, 0);
                foreach($favorites as $favorite){
                    if($user->id == $favorite->user_id){
                        if($shops[$i]->id == $favorite->shop_id){
                            $favorites_flag[$i] = 1;
                        }
                    }
                }
            }
        }

        for($i=1; $i<=count($shops); $i++){
            array_push($evaluation_ave, 0);
            array_push($evaluation_n, 0);
            $records = Evaluation::where('shop_id', '=', $i)->get();
            $sum = 0;
            $count = 0;
            foreach($records as $record){
                $sum += $record->evaluation;
                $count++;
            }
            if($count){
                $evaluation_ave[$i] = round($sum/$count, 1);
                $evaluation_n[$i] = $count;
            }else{
                $evaluation_ave[$i] = 0;
                $evaluation_n[$i] = 0;
            }
        }

        $param = ['user' => $user, 
                    'categories' => $categories, 
                    'regions' => $regions, 
                    'shops' => $results, 
                    'favorites_flag' => $favorites_flag, 
                    'evaluation_ave' => $evaluation_ave,
                    'evaluation_n' => $evaluation_n];

        return view('home', $param);
    }

    public function goToChangeReserve($reserve_id){
        $reserve_data = Reserve::find($reserve_id);
        return view('changeReserve', ['reserve_data' => $reserve_data]);
    }

    public function changeReserve(ReserveRequest $request,$reserve_id){
        $form = $request -> all();
        unset($form['_token']);
        Reserve::find($reserve_id)->update($form);
        return redirect('/mypage');
    }

    public function payment(Request $request){
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create(array(
            'amount' => 2000,
            'currency' => 'jpy',
            'source' => request()->stripeToken
        ));
        return back();
    }

}
