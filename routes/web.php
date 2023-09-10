<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/skills', [ProfileController::class, 'editSkills'])->name('profile.skills.edit');
});

Route::resource('jobs', JobController::class)
    ->only(['index', 'create', 'store', 'edit', 'update'])
    ->middleware(['auth', 'verified']);

Route::resource('skills', SkillController::class)
    ->only(['index', 'create', 'store', 'edit', 'update'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
