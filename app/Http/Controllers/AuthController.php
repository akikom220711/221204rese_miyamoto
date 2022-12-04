<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function goToRegister(){
        return view('regist');
    }

    public function register(RegisterRequest $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $email = $request -> email;
        $password = $request -> password;
        if (Auth::guard('users')->attempt(['email' => $email, 'password' => $password])){
            return redirect('/email/verify');
        }else{
            return redirect('/userlogin');
        }
    }

    public function thanks(){
        return view('thanks');
    }

    public function goToLogin(Request $request){
        $data = $request -> session()->get('data');
        $error = "";
        if(!$data){
            $data = ['email' => ''];
        }else{
            $error = trans('auth.failed');
        }
        return view('login', ['data' => $data, 'error' => $error]);
    }

    public function login(LoginRequest $request){
        $email = $request -> email;
        $password = $request -> password;
        if (Auth::guard('users')->attempt(['email' => $email, 'password' => $password])){
            return redirect('/');
        }else{
            $data = $request->only('email');
            $request->session()->flash('data', $data);
            return redirect('/userlogin');
        }
    }

    public function logout(){
        Auth::guard('users')->logout();
        return redirect('/');
    }
}
