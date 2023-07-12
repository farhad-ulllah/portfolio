<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostController;
// Route::middleware(['auth','varified'])->group(function(){

// });

Route::middleware(['auth.passport'])->prefix('admin')->name('admin.')->group(function(){
   //Admin Dashboard Route
    Route::get('/dashboard', [AuthController::class,'AdminDashboard'])->name('dashboard');
    Route::resource('posts', PostController::class);
    Route::post('/posts_update', [PostController::class,'Update'])->name('posts_update');
    Route::get('data-table', [PostController::class,'dataTable'])->name('data-table');

});
Route::post('/admin/login', [AuthController::class,'login'])->name('admin.login');
Route::post('/admin/register', [AuthController::class,'register'])->name('admin.register');

Route::get('/supperadmin', [AuthController::class,'AddSupperAdmin']);
?>