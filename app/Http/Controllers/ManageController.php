<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ManageRequest;
use App\Http\Requests\ShopRequest;
use App\Http\Requests\MailRequest;
use App\Models\Manager;
use App\Models\Region;
use App\Models\Category;
use App\Models\Shop;
use App\Models\Reserve;
use App\Models\User;
use App\Mail\SendMail;

class ManageController extends Controller
{
    public function goToAdmin(){
        $users = User::all();
        $managers = Manager::all();
        $users = $users -> concat($managers);
        $param = ['users' => $users];

        return view('admin', $param);
    }

    public function registManager(ManageRequest $request){
        Manager::create([
            'name' => $request->manager_name,
            'email' => $request->manager_email,
            'password' => Hash::make($request->manager_password),
            'permission' => 1
        ]);
        return view('doneManagerRegist');
    }

    public function goToManage(){
        $users = User::all();
        $manager = Auth::guard('managers')->user();
        $shops = Shop::where('manager_id', '=', $manager['id'])->get();
        $param = ['manager' => $manager, 'users' => $users, 'shops' => $shops ];

        return view('manageHome', $param);
    }

    public function goToCreateShop(){
        $regions = Region::all();
        $categories = Category::all();
        $manager = Auth::guard('managers')->user();
        $param = ['regions' => $regions, 'categories' => $categories, 'manager' => $manager];
        return view('createShop', $param);
    }

    public function createShop(ShopRequest $request, $manager_id){
        Shop::create([
            'shop_name' => $request->shop_name,
            'comment' => $request->comment,
            'url' => $request->url,
            'region_id' => $request->region_id,
            'category_id' => $request->category_id,
            'manager_id' => $manager_id,
        ]);

        return view('doneCreateShop');
    }

    public function goToUpdateShop($manager_id, $shop_id){
        $regions = Region::all();
        $categories = Category::all();
        $manager = Auth::guard('managers')->user();
        $shop = Shop::find($shop_id);
        
        $param = ['regions' => $regions, 'categories' => $categories, 'manager' => $manager, 'shop' => $shop];
        return view('updateShop', $param);
    }

    public function updateShop(ShopRequest $request, $shop_id){
        $form = $request -> all();
        unset($form['_token']);
        Shop::find($shop_id)->update($form);
        return view('doneUpdateShop');
    }

    public function showReserve($shop_id){
        $shop = Shop::find($shop_id);
        $reserves = Reserve::where('shop_id', '=', $shop_id)->get();
        $param = ['reserves' => $reserves, 'shop' => $shop];

        return view('showReserve', $param);
    }

    public function sendMailForUser(MailRequest $request){
        $form = $request -> all();
        unset($form['_token']);

        Mail::to($form['mail_address'])->send(new SendMail($form));
        return back();
    }
}
