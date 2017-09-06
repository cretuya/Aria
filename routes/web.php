<?php

use Illuminate\Http\Request;	
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();
Route::middleware(['auth'])->group(function(){

	Route::get('/', function () {
		// dd(Auth::user());
	    return view('index');
	});

	// Route::get('user/profile', function () {
	//     return view('user-profile');
	// });

	Route::get('user/profile', 'UserController@show');

	Route::post('edit/profile', 'UserController@updateUser');

	Route::post('createband', 'BandController@createBand');
	Route::get('{band_name}/manage', 'BandController@index');
	Route::get('{band_name}', 'BandController@show');

	Route::post('editband', 'BandController@editBand');
	Route::post('editbandPic', 'BandController@editBandPic');
	Route::get('{band_name}/manage/search', 'BandController@search');
	Route::post('addmember', 'BandMemberController@addBandMember');
	Route::post('deletemember', 'BandMemberController@deleteBandMember');

	Route::get('{band_name}/albums', 'AlbumController@index');
	Route::post('{band_name}/addAlbum' , 'AlbumController@addAlbum');
	Route::get('{band_name}/albums/{album_id}', 'AlbumController@viewAlbum');
	Route::get('{band_name}/editAlbum/{album_id}' , 'AlbumController@editAlbum');
	Route::post('{band_name}/updateAlbum' , 'AlbumController@updateAlbum');
	Route::get('/deleteAlbum/{album_id}', 'AlbumController@deleteAlbum');

	Route::get('{band_name}/{album_id}/songs', 'SongController@index');
	Route::post('{band_name}/addSongs' , 'SongController@addSongs');
	Route::post('{band_name}/viewSongs', 'SongController@viewSongs');
	Route::get('editSong/{song_id}', 'SongController@editSong');
	Route::post('{band_name}/updateSong', 'SongController@updateSong');
	Route::post('deleteSong/{song_id}', 'SongController@deleteSong');

	Route::post('{band_name}/addVideo', 'VideoController@addVideo');
	Route::get('{band_name}/editVideo/{video_id}' , 'VideoController@editVideo');
	Route::post('{band_name}/updateVideo' , 'VideoController@updateVideo');
	Route::get('{band_name}/deleteVideo/{video_id}' , 'VideoController@deleteVideo');


	Route::get('{band_name}/articles', 'ArticleController@index');
	Route::post('{band_name}/addArticle', 'ArticleController@addArticle');
	Route::get('{band_name}/viewArticle/{article_id}', 'ArticleController@viewArticle');
	Route::get('/deleteArticle/{article_id}' , 'ArticleController@deleteArticle');
	Route::get('{band_name}/editArticle/{article_id}', 'ArticleController@editArticle');
	Route::post('{band_name}/updateArticle', 'ArticleController@updateArticle');



});
