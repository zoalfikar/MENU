<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

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

Route::get('/frontend-route/{vue_capture?}', function () {
return redirect('/');
})->where('vue_capture', '[\/\w\.-]*');



Route::get('/', [Controller::class ,"redirect"]);
Route::get('/user', [Controller::class ,"getUser"])->middleware(['auth']);






Route::get('/show-login', function () {
    return view('login');
})->middleware('un_auth');

Route::post('/login', [AuthController::class,'login'])->middleware('un_auth');
Route::get('/logout', [AuthController::class,'logout'])->middleware('auth');



Route::group(['middleware' => ['auth' ,'admin']], function () {
    Route::get('/admin/dashboard', function () {
        return view('admin_dashboard');
    });

    Route::resource('items', ItemController::class);

    Route::post('categories/discount/all', [CategoryController::class,'setDisAcountForAllMenu']);
    Route::resource('categories', CategoryController::class);


    Route::resource('users', UserController::class);

});



Route::group(['middleware' => ['auth' ,'user']], function () {

    Route::get('/menu', function () {
        return view('menu');
    });
    Route::get('/menu/get', [CategoryController::class,'index']);
});



