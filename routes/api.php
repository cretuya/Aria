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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('updateUserInfo', 'Api\UserController@updateUser');

Route::get('createband', 'Api\BandController@createBand');

Route::get('editband', 'Api\BandController@editBand');
Route::get('editbandPic', 'Api\BandController@editBandPic');
Route::get('searchForBandMember', 'Api\BandController@search');
Route::get('addmember', 'Api\BandMemberController@addBandMember');
Route::get('deletemember', 'Api\BandMemberController@deleteBandMember');

Route::get('videos', 'Api\VideoController@videos');
Route::get('addVideo', 'Api\VideoController@addVideo');
Route::get('deleteVideo','Api\VideoController@deleteVideo');
Route::get('editVideo', 'Api\VideoController@editVideo');
Route::get('updateVideo', 'Api\VideoController@updateVideo');


Route::get('albums', 'Api\AlbumController@albums');
Route::get('addAlbum', 'Api\AlbumController@addAlbum');
Route::get('deleteAlbum','Api\AlbumController@deleteAlbum');
Route::get('editAlbum', 'Api\AlbumController@editAlbum');
Route::get('updateAlbum', 'Api\AlbumController@updateAlbum');


Route::get('songs', 'Api\SongController@songs');
Route::get('addSongs' , 'Api\SongController@addSongs');
Route::get('editSong', 'Api\SongController@editSong');
Route::get('updateSong', 'Api\SongController@updateSong');
Route::get('deleteSong', 'Api\SongController@deleteSong');

Route::get('articles', 'Api\ArticleController@articles');
Route::get('addArticle', 'Api\ArticleController@addArticle');
Route::get('viewArticle', 'Api\ArticleController@viewArticle');
Route::get('deleteArticle' , 'Api\ArticleController@deleteArticle');
Route::get('editArticle', 'Api\ArticleController@editArticle');
Route::get('updateArticle', 'Api\ArticleController@updateArticle');

Route::get('genres', 'Api\AlbumController@genres');

