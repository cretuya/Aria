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

	Route::get('home', 'UserController@homeshow');
	Route::get('feed', 'UserController@feedshow');
	Route::get('friends', 'UserController@friends');
	Route::get('profile/{user_id}', 'UserController@friendprofile');

	Route::get('charts', 'ChartsController@show');

	Route::get('search','SearchController@search');

	Route::get('user/profile', 'UserController@profileshow');
	Route::post('edit/profile', 'UserController@updateUser');
	Route::get('home', 'DiscoverPageController@showAllGenres');
	Route::get('discover/playlist/{genre_id}', 'DiscoverPageController@showSongsGenre');
	Route::get('discover/{genre_name}', 'DiscoverPageController@showAccordingtoGenre');

	Route::post('createband', 'BandController@createBand');
	Route::get('{band_name}/manage', 'BandController@index');
	Route::get('{band_name}', 'BandController@show');

	Route::post('editband', 'BandController@editBand');
	Route::post('editbandPic', 'BandController@editBandPic');
	Route::post('editbandCoverPic', 'BandController@editBandCoverPic');
	Route::get('{band_name}/manage/search', 'BandController@search');
	Route::post('addmember', 'BandMemberController@addBandMember');
	Route::post('deletemember', 'BandMemberController@deleteBandMember');
	Route::post('acceptRequest', 'BandMemberController@acceptRequest');
	Route::post('ignoreRequest', 'BandMemberController@ignoreRequest');
	Route::post('editrolemember', 'BandMemberController@editrolemember');

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


	Route::post('{band_name}/addArticle', 'ArticleController@addArticle');
	Route::get('{band_name}/viewArticle/{article_id}', 'ArticleController@viewArticle');
	Route::get('/deleteArticle/{article_id}' , 'ArticleController@deleteArticle');
	Route::get('{band_name}/editArticle/{article_id}', 'ArticleController@editArticle');
	Route::post('{band_name}/updateArticle', 'ArticleController@updateArticle');
	Route::get('{bname}/getArticle', 'ArticleController@getArticle');

	Route::get('{band_name}/videos', 'VideoController@videos');
	Route::get('{band_name}/albums', 'AlbumController@albums');
	Route::get('{band_name}/articles', 'ArticleController@articles');
	Route::post('getArticle', 'ArticleController@getArticle');	
	Route::post('followBand', 'BandController@followBand');
	Route::post('unfollowBand', 'BandController@unfollowBand');
	Route::post('likeAlbum', 'AlbumController@likeAlbum');
	Route::post('unlikeAlbum', 'AlbumController@unlikeAlbum');
	Route::post('addSongPlayed', 'SongController@addSongPlayed');
	Route::post('visitCount', 'BandController@visitCount');

	Route::post('createplaylist', 'UserController@createplaylist');
	Route::get('playlist/delete/{pl_id}', 'UserController@deleteplaylist');
	Route::post('editplaylist', 'UserController@editplaylist');
	Route::post('updateplaylist', 'UserController@updateplaylist');
	Route::get('delplsong/{song_id}/{pl_id}', 'UserController@delplsong');
	

	Route::get('playlist/{pl_id}', 'UserController@viewplaylist');
	// Route::post('addtonlist', 'UserController@addtonlist');
	// Route::post('nrecommend', 'UserController@nrecommend');
	// Route::post('addtolist', 'UserController@addtolist');
	// Route::post('listrecommend', 'UserController@listrecommend');
	Route::post('addSongToPlaylist', 'UserController@addSongToPlaylist');

});
