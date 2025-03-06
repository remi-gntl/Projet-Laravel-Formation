<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\TestStatus\Risky;

use App\Http\Controllers\{
    ArticleController,
    LoginController,
    UserController,
    RegisterController,
    LogoutController,
    ForgotController,
    ResetController,
    CommentController,
    CategoryController
};

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('forgot', [ForgotController::class,'index'])->name('forgot');
Route::get('reset/{token}',[ResetController::class,'index'])->name('reset');
Route::get('user/password', [UserController::class,'password'])->name('user.password');
Route::get('category/{category}', [CategoryController::class,'show'])->name('category.show');


Route::get('user/edit', [UserController::class,'edit'])->name('user.edit');
Route::post('user/store', [UserController::class,'store'])->name('post.user');

Route::post('password', [UserController::class, 'updatePassword'])->name('update.password');
Route::post('comment/{article}', [CommentController::class, 'store'])->name('post.comment');
Route::post('reset', [ResetController::class, 'reset'])->name('post.reset');
Route::post('register', [RegisterController::class, 'register'])->name('post.register');
Route::post('login', [LoginController::class, 'login'])->name('post.login');
Route::post('forgot',[ForgotController::class,'store'])->name('post.forgot');

Route::get('profile/{user}', [UserController::class, 'profile'])->name('user.profile');

Route::resource('articles', ArticleController::class)->except('index');

Route::delete('destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/', [ArticleController::class, 'index']);

/*
Route::get('test',function(){
    return view('test');
});

Route::get('test2', function(){
    return view('test2');
});


Route::get('index', function(){
    return view('profile.index', [
        'firstname' => 'Le',
        'lastname' => 'Boss'        
    ]);
});

Route::get('structures', function(){
    $fruits = ['pommes', 'peches', 'poires', 'abricots'];
    $data = [
        'number'=>5,
        'fruits'=>$fruits,
    ];
    return view('structures', $data);
});
*/