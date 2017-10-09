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

Route::post('updateUserInfo', 'Api\UserController@updateUser');
Route::post('saveUser', 'Api\UserController@saveUser');

Route::post('createBand', 'Api\BandController@createBand');
Route::get('getBand', 'Api\BandController@getBand');
// Route::get('updateBand', 'Api\BandController@updateBand');
Route::get('editbandPic', 'Api\BandController@editBandPic');
Route::get('searchForBandMember', 'Api\BandController@search');
Route::post('addmember', 'Api\BandMemberController@addBandMember');
Route::get('deletemember', 'Api\BandMemberController@deleteBandMember');

Route::get('videos', 'Api\VideoController@videos');
Route::post('addVideo', 'Api\VideoController@addVideo');
Route::get('deleteVideo','Api\VideoController@deleteVideo');
Route::get('editVideo', 'Api\VideoController@editVideo');
Route::post('updateVideo', 'Api\VideoController@updateVideo');


Route::get('albums', 'Api\AlbumController@albums');
Route::post('addAlbum', 'Api\AlbumController@addAlbum');
Route::get('deleteAlbum','Api\AlbumController@deleteAlbum');
Route::get('editAlbum', 'Api\AlbumController@editAlbum');
Route::post('updateAlbum', 'Api\AlbumController@updateAlbum');


Route::get('songs', 'Api\SongController@songs');
Route::post('addSongs' , 'Api\SongController@addSongs');
Route::get('editSong', 'Api\SongController@editSong');
Route::post('updateSong', 'Api\SongController@updateSong');
Route::get('deleteSong', 'Api\SongController@deleteSong');

Route::get('articles', 'Api\ArticleController@articles');
Route::post('addArticle', 'Api\ArticleController@addArticle');
Route::get('viewArticle', 'Api\ArticleController@viewArticle');
Route::get('deleteArticle' , 'Api\ArticleController@deleteArticle');
Route::get('editArticle', 'Api\ArticleController@editArticle');
Route::post('updateArticle', 'Api\ArticleController@updateArticle');

Route::get('genres', 'Api\AlbumController@genres');

Route::get('getArticle', 'Api\ArticleController@getArticle');
Route::get('followBand', 'Api\BandController@followBand');
Route::get('unfollowBand', 'Api\BandController@unfollowBand');
Route::get('likeAlbum', 'Api\AlbumController@likeAlbum');
Route::get('unlikeAlbum', 'Api\AlbumController@unlikeAlbum');
Route::get('addSongPlayed', 'Api\SongController@addSongPlayed');
Route::get('visitCount', 'Api\BandController@visitCount');
