<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/getArticles', [ArticleController::class, 'getAllArticle']);
Route::post('/createArticle', [ArticleController::class, 'store']);
Route::put('/updateArticle/{id}', [ArticleController::class, 'updateArticle']);
Route::delete('/deleteArticle/{id}', [ArticleController::class, 'deleteArticle']);


Route::post('/contact', [ContactController::class, 'store']);
Route::get('/getContacts', [ContactController::class, 'index']);