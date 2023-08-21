<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdineController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MailController;
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
// Rotte private
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [UserController::class, 'logout']);
    //Rotte casse; Separare endpoint in base ai permessi
    Route::get('/casse', [OrdineController::class,'getCasse'] );
    Route::post('/ordine', [OrdineController::class,'CreateOrder'] );
   
});

// Rotte esclusive Admin
Route::group(['middleware' => ['auth:sanctum', 'admin']], function(){
    Route::get('/ordine', [OrdineController::class,'GetOrders'] );
    Route::get('/storico', [OrdineController::class,'GetStorico'] );
    Route::post('/acquista', [OrdineController::class,'ProcessOrder'] );
    Route::get('export/{user_id}', [OrdineController::class, 'export']);
});



//Rotte pubbliche
//localhost:8000/api/
Route::get('/test', [UserController::class,'index'] );
Route::post('/user', [UserController::class,'store'] );
Route::post('/login', [UserController::class,'login'] );

Route::post('/categoryFilter', [ArticleController::class,'GetArticlesByCategory'] );
Route::get('/articles', [ArticleController::class,'GetArticles'] );
Route::post('/findArticles', [ArticleController::class,'FindArticle'] );


Route::post('/send-email', [MailController::class, 'sendEmail']);