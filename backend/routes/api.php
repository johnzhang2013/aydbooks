<?php

use Illuminate\Http\Request;

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

Route::post('login', 'AuthController@login');

//Api Routes for frontend requests
Route::group(['prefix' => 'frontend'], function($router) {
    Route::get('book/basics', 'BookController@basics');
    Route::post('book/list', 'BookController@list');    
    Route::post('uploadimg', 'UploadController@uploadImage');
    Route::post('pdfmerge', 'PDFMergeController@merge');

    //Api Routes for auth
    Route::group(['middleware' => ['auth:user']], function($router) {
        Route::post('logout', 'AuthController@logout');

        Route::post('book/borrowit', 'BookController@borrow');
        Route::get('user/profile', 'MemberController@profile');
        Route::post('user/brr', 'MemberController@borrowReturnRecords');        
    });
    
});

//Api routes for backend requests
Route::group(['prefix' => 'backend'], function($router) {
    Route::group(['middleware' => ['auth:admin']], function($router) {
        Route::post('logout', 'AuthController@logout');

        Route::get('book/basics', 'BookController@basics');
        Route::post('book/list', 'BookController@list');
        Route::post('bookcate/list', 'BookCategoryController@list');

        Route::post('author/list', 'AuthorController@list');

        Route::get('dashboard/book_stat', 'DashboardController@getBookStat');
        Route::get('dashboard/book_tops', 'DashboardController@getTopCount');

        /*Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('profile', 'AuthController@profile');

        Route::post('member/list', 'MemberController@list');
        Route::get('member/view', 'MemberController@view');

        Route::post('member/search', 'MemberController@search');
        Route::post('member/update', 'MemberController@update');
        Route::post('member/delete', 'MemberController@delete');*/
    });

});