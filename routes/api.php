<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\WebServiceController;

Route::prefix('v1')->group(function () {
    Route::post('login', [WebServiceController::class, 'login']);
    /*********************************** START GET ****************************************/
    Route::get('users', [WebServiceController::class,'getUsers']);
    Route::get('company', [WebServiceController::class,'getCompany']);
    Route::get('articles', [WebServiceController::class,'getArticles']);
    /*********************************** START POST **************************************/
    Route::post('users', [WebServiceController::class,'postUser']);
    Route::post('company', [WebServiceController::class,'postCompany']);
    Route::post('articles', [WebServiceController::class,'postArticle']);
});
