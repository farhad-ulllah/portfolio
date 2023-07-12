<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Api\ReferralController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/test', function (Request $request) {
//     return '$request->user();';
// });
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware(['auth:api'])->prefix('user')->name('user.')->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::resource('posts', PostController::class);
    Route::post('posts/update', [PostController::class, 'update'])->name('posts.update');
    Route::get('data-table', [PostController::class, 'dataTable'])->name('posts.data-table');

    Route::get('superadmin', [AuthController::class, 'addSuperAdmin']);

    // Referral routes
    Route::post('referrals', [ReferralController::class, 'store'])->name('referrals.store');
    Route::put('referrals/{referral}', [ReferralController::class, 'update'])->name('referrals.update');
    Route::delete('referrals/{referral}', [ReferralController::class, 'destroy'])->name('referrals.destroy');

    //User Profile
    Route::post('/user/profile', [UserController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
//Admin Dashboard Apis
Route::middleware('auth:api')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'getAllUsers'])->name('users');
    Route::get('/users/{user}/referrals', [AdminController::class, 'getUserReferrals'])->name('users.referrals');
    Route::post('/users/{user}/bonus', [AdminController::class, 'addBonusToUser'])->name('users.bonus');

    Route::put('referrals/{referral}/success', [ReferralController::class, 'markSuccess']);
    Route::put('referrals/{referral}/active', [ReferralController::class, 'markActive']);
    Route::put('referrals/{referral}/declined', [ReferralController::class, 'markDeclined']);
    Route::put('referrals/{referral}/bonus', [ReferralController::class, 'addBonus']);
});


// Route::middleware('auth:api')->group(function () {
// Email verification route
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully.'], 200);
})->name('verification.verify');
// });


// Route::middleware('auth:api')->group(function () {

// });


Route::get('/forgot-password', [AuthController::class, 'ForgotPassword'])->name('forgot-password');
Route::post('/ForgetPassword', [AuthController::class, 'ForgetPassword'])->name('ForgetPassword');
Route::get('/password/reset/{token}', [AuthController::class, 'ResetPassword'])->name('password.reset');
Route::post('/save/password', [AuthController::class, 'SubmitResetPassword'])->name('save.password');
