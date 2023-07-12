<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostController;

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

Route::get('/', function () {
    return view('admin.auth.login');
});
// Route::get('/login', function () {
//     return view('admin.auth.login');
// })->name('login');
// Route::get('/register', function () {
//     return view('admin.auth.register');
// })->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'ForgotPassword'])->name('forgot-password');
Route::post('/ForgetPassword', [AuthController::class, 'ForgetPassword'])->name('ForgetPassword');
Route::get('/password/reset/{token}', [AuthController::class, 'ResetPassword'])->name('password.reset');
Route::post('/save/password', [AuthController::class, 'SubmitResetPassword'])->name('save.password');

Route::post('image-upload', [PostController::class, 'storeImage'])->name('image.upload');
