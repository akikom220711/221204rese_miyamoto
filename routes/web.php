<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\ManagerAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');

Route::get('/regist', [AuthController::class, 'goToRegister']);
Route::post('/regist', [AuthController::class, 'register']);
Route::get('/thanks', [AuthController::class, 'thanks']);
Route::get('/userlogin', [AuthController::class, 'goToLogin'])->name('userlogin');
Route::post('/userlogin', [AuthController::class, 'login']);
Route::get('/userlogout', [AuthController::class, 'logout'])->middleware('auth:users');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth:users')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) { 
  $request->fulfill();
    return redirect('/');
})->middleware(['auth:users', 'signed'])->name('verification.verify');


Route::prefix('manager')->group(function (){
  Route::get('/userlogin', [ManagerAuthController::class, 'goToLogin']);
  Route::post('/userlogin', [ManagerAuthController::class, 'login']);
  Route::get('/userlogout', [ManagerAuthController::class, 'logout'])->middleware('auth:managers');
});

//userのみアクセス可
Route::group(['middleware' => ['auth:users', 'can:user_only', 'verified']], function(){
  Route::get('/favorite/{user_id}/{shop_id}', [ShopController::class, 'favorite']);
  Route::get('/deleteFavorite/{user_id}/{shop_id}', [ShopController::class, 'deleteFavorite']);
  Route::get('/reserve/{user_id}/{shop_id}', [ShopController::class, 'reserve']);
  Route::post('/confirm/{user_id}/{shop_id}', [ShopController::class, 'confirm']);
  Route::get('/done', [ShopController::class, 'doneReserve']);
  Route::get('/deleteReserve/{reserve_id}', [ShopController::class, 'deleteReserve'])->name('deleteReserve');
  Route::get('/mypage', [ShopController::class, 'mypage']);
  Route::get('/goToChangeReserve/{reserve_id}', [ShopController::class, 'goToChangeReserve']);
  Route::post('/changeReserve/{reserve_id}', [ShopController::class, 'changeReserve']);
  Route::get('/evaluation/{reserve_id}', [ShopController::class, 'goToEvaluation']);
  Route::post('/evaluation/{reserve_id}', [ShopController::class, 'evaluation']);
  Route::post('/payment', [ShopController::class, 'payment']);
});

Route::get('/search', [ShopController::class, 'search']);

//adminのみアクセス可
Route::group(['middleware' => ['auth:users', 'can:admin_only']], function(){
  Route::get('/admin',[ManageController::class, 'goToAdmin']);
  Route::post('/admin',[ManageController::class, 'registManager']);
});

//managerでログインしたときのみアクセス可
Route::group(['middleware' => ['auth:managers']], function(){
  Route::get('/manage',[ManageController::class, 'goToManage']);
  Route::get('/createShop',[ManageController::class, 'goToCreateShop']);
  Route::post('/createShop/{manager_id}',[ManageController::class, 'createShop']);
  Route::get('/goToUpdateShop/{manager_id}/{shop_id}',[ManageController::class, 'goToUpdateShop']);
  Route::post('/updateShop/{shop_id}',[ManageController::class, 'updateShop']);
  Route::get('/showReserve/{shop_id}',[ManageController::class, 'showReserve']);
});

Route::post('/sendMailForUser',[ManageController::class, 'sendMailForUser']);

require __DIR__.'/auth.php';
