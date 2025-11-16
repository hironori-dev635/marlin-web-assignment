<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\InertiaTestController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Post;

Route::get('/inertia-test', function () {
    return Inertia::render('InertiaTest');
}
);
Route::get('/component-test', function () {
    return Inertia::render('ComponentTest');
}
);
Route::get('/form-test', function () {
    return Inertia::render('FormTest', [
        'posts' => Post::all()->toArray(), // 配列に変換して渡す
    ]);
});
// userモデルを使ったインデックスページ機能
Route::get('/user', [UserController::class, 'index'])->name('users.index');
Route::get('/usersort', [UserController::class, 'index1'])->name('users.sort1');
Route::get('/userpaginate', [UserController::class, 'index2'])->name('users.paginate2');
Route::get('/usersearch1', [UserController::class, 'search1'])->name('users.search1');
Route::get('/usersearch2', [UserController::class, 'search2'])->name('users.search2');
Route::get('/usersearch3', [UserController::class, 'search3'])->name('users.search3');
Route::get('/usermodal', function () {
    return Inertia::render('Users/UserModal');
}
);

Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::resource('documents', DocumentController::class);


Route::get('/inertia/index',[InertiaTestController::class, 'index'])->name('inertia.index');
Route::get('/inertia/create',[InertiaTestController::class, 'create'])->name('inertia.create');
Route::post('/inertia',[InertiaTestController::class, 'store'])->name('inertia.store');
Route::get('/inertia/show/{id}',[InertiaTestController::class, 'show'])->name('inertia.show');
Route::delete('/inertia/{id}',[InertiaTestController::class, 'delete'])->name('inertia.delete');


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
