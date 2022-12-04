<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ManagerAuthController extends Controller
{

    public function goToLogin(Request $request){
        $data = $request -> session()->get('data');
        $error = "";
        if(!$data){
            $data = ['email' => ''];
        }else{
            $error = trans('auth.failed');
        }
        return view('loginManager',['data' => $data, 'error' => $error]);
    }

    public function login(LoginRequest $request){
        $email = $request -> email;
        $password = $request -> password;
        if (Auth::guard('managers')->attempt(['email' => $email, 'password' => $password])){
            return redirect('/manage');
        }else{
            $data = $request->only('email');
            $request->session()->flash('data', $data);
            return redirect('/manager/userlogin');
        }
    }

    public function logout(){
        Auth::guard('managers')->logout();
        return redirect('/');
    }
}
