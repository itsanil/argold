<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\FrontController;

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
// Route::get('/about',function(){
//    return view('about');
// })->name('about');
Route::get('/about',[FrontController::class, 'about'])->name('about');
Route::resource('products','ProductController');

Route::get('/', function (){
   if(Auth::guard('admin')->check()) {
      return AdminLoginController::redirectBasedOnUser();
    } else {
      return view('admin-auth.login');
   }
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

