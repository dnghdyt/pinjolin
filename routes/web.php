<?php

use App\Http\Controllers\ArticlesController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('index', [
    'articles' => Article::latest()->take(5)->get(),
  ]);
})->name('home');

Route::resource('/blog', ArticlesController::class);