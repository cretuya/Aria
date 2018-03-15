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
Route::post('saveUser', 'Api\UserController@saveUser');
Route::post('updateUserInfo', 'Api\UserController@updateUser');


Route::post('createBand', 'Api\BandController@createBand');


// Route::get('updateBand', 'Api\BandController@updateBand');
Route::post('editbandPic', 'Api\BandController@editBandPic');
Route::get('searchForBandMember', 'Api\BandController@search');
Route::post('addmember', 'Api\BandMemberController@addBandMember');
Route::get('deletemember', 'Api\BandMemberController@deleteBandMember');


Route::post('addVideo', 'Api\VideoController@addVideo');
Route::get('deleteVideo','Api\VideoController@deleteVideo');
Route::get('editVideo', 'Api\VideoController@editVideo');
Route::post('updateVideo', 'Api\VideoController@updateVideo');


Route::post('addAlbum', 'Api\AlbumController@addAlbum');
Route::get('deleteAlbum','Api\AlbumController@deleteAlbum');
Route::get('editAlbum', 'Api\AlbumController@editAlbum');
Route::post('updateAlbum', 'Api\AlbumController@updateAlbum');


Route::post('addSongs' , 'Api\SongController@addSongs');
Route::get('editSong', 'Api\SongController@editSong');
Route::get('updateSong', 'Api\SongController@updateSong');
Route::get('deleteSong', 'Api\SongController@deleteSong');


Route::post('addArticle', 'Api\ArticleController@addArticle');
Route::get('viewArticle', 'Api\ArticleController@viewArticle');
Route::get('deleteArticle' , 'Api\ArticleController@deleteArticle');
Route::get('editArticle', 'Api\ArticleController@editArticle');
Route::post('updateArticle', 'Api\ArticleController@updateArticle');



Route::post('followBand', 'Api\BandController@followBand');
Route::post('unfollowBand', 'Api\BandController@unfollowBand');
Route::post('likeAlbum', 'Api\AlbumController@likeAlbum');
Route::post('unLikeAlbum', 'Api\AlbumController@unLikeAlbum');
Route::get('addSongPlayed', 'Api\SongController@addSongPlayed');
Route::post('visitCount', 'Api\BandController@visitCount');

Route::get('getusers', 'Api\UserController@getusers');

Route::get('bands', 'Api\BandController@bands');
Route::get('getBand', 'Api\BandController@getBand');

Route::get('members', 'Api\BandMemberController@members');
Route::get('bandmembers', 'Api\BandMemberController@bandmembers');

Route::get('videos', 'Api\VideoController@videos');
Route::post('bandvideos', 'Api\VideoController@bandvideos');


Route::get('bandalbums', 'Api\AlbumController@bandalbums');

Route::get('songs', 'Api\SongController@songs');
Route::post('bandsongs', 'Api\SongController@bandsongs');

Route::get('articles', 'Api\ArticleController@articles');
Route::get('bandarticles', 'Api\ArticleController@bandarticles');
Route::get('getArticle', 'Api\ArticleController@getArticle');

Route::get('genres', 'Api\AlbumController@genres');
Route::get('bandgenres', 'Api\AlbumController@bandgenres');

Route::post('preferences', 'Api\UserController@preferences');
Route::get('userhistory','Api\UserController@userhistory');

Route::post('AddPlayList', 'Api\UserController@AddPlayList');
Route::get('DeletePlayList', 'Api\UserController@DeletePlayList');
Route::post('updateplaylist', 'Api\UserController@updateplaylist');
Route::get('getAllPlaylist', 'Api\UserController@getAllPlaylist');
Route::post('addSongToPlaylist', 'Api\UserController@addSongToPlaylist');
Route::get('getAllPlist','Api\UserController@getAllPlist');
Route::get('AllAlbums','Api\AlbumController@AllAlbums');
Route::get('removeSongFromPlaylist','Api\UserController@removeSongFromPlaylist');

Route::post('getPlistById', 'Api\UserController@getPlistById');
Route::get('getEvents', 'Api\BandController@getEvents');
Route::post('addBandCoverPhoto', 'Api\BandController@addBandCoverPhoto');
Route::post('addEvent', 'Api\BandController@addEvent');
Route::post('followPlaylist','Api\UserController@followPlaylist');
Route::post('unFollowPlaylist','Api\UserController@unFollowPlaylist');
Route::get('getBandGenres', 'Api\BandController@getBandGenres');
Route::get('genreFamily', 'Api\SongController@genreFamily');
Route::get('searchFunction','Api\UserController@searchFunction');
Route::post('inviteUser', 'Api\BandMemberController@inviteUser');
Route::get('getUserNotification', 'Api\BandMemberController@getUserNotification');
Route::post('declineInvitation', 'Api\BandMemberController@declineInvitation');
Route::get('scoringfunc', 'Api\BandController@scoringfunc');
Route::post('songPlayed', 'Api\SongController@songPlayed');
