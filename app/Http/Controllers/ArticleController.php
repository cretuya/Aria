<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserNotification;
use App\Band;
use App\BandArticle;
use App\Article;
use Validator;
class ArticleController extends Controller
{

    public function articles($bname)
    {
        $band = Band::where('band_name', $bname)->first();
        $articles = $band->bandarticles;
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
        return view('article', compact('band', 'articles','usernotifinvite'));
    }
    public function addArticle(Request $request , $bname)
    {
    	$band = Band::where('band_name', $bname)->first();
        $title = $request->input('art_title');
        $content = $request->input('content');
        $rules = new Article;
        $validator = Validator::make($request->all(), $rules->rules);

        if($validator->fails())
        {
            return redirect('/'.$band->band_name.'/manage')->withErrors($validator)->withInput();
        }
        else
        {
            $create = Article::create([
                'art_title' => $title,
                'content' => $content,
            ]);

            $createBandArticle = BandArticle::create([
            	'band_id' => $band->band_id,
            	'art_id' => $create->art_id , 
            ]);
            return redirect('/'.$band->band_name.'/manage');
        }
    }
    public function viewArticle($bname, $aid)
    {
        $band = Band::where('band_name', $bname)->first();
        $article = Article::where('art_id', $aid)->first();

        return view('view-band-article', compact('band', 'article'));
    }
    public function deleteArticle($aid)
    {
        $art = BandArticle::where('art_id', $aid)->first();
        $bid = $art->band_id;
        $band = Band::where('band_id', $bid)->first();

        $delete = Article::where('art_id', $aid)->delete();



        return redirect('/'.$band->band_name.'/manage');
    }
    public function editArticle($bname,$aid)
    {
        $band = Band::where('band_name', $bname)->first();
        $article = Article::where('art_id', $aid)->first();

        return view('edit-band-article', compact('band', 'article'));
    }
    public function updateArticle($bname, Request $request)
    {
        $band = Band::where('band_name', $bname)->first();
        $title = $request->input('art_title');
        $content = $request->input('content');
        $aid = $request->input('art_id');
        $rules = new Article;
        $validator = Validator::make($request->all(), $rules->updaterules);

        if ($validator->fails())
        {
            return redirect('/'.$bname.'/manage')->withErrors($validator)->withInput();
        }
        else
        {
            $update = Article::where('art_id', $aid)->update([
                'art_title' => $title,
                'content' => $content,
            ]);
            return redirect('/'.$bname.'/manage');
        }
    }    
    public function getArticle(Request $request)
    {
        $article = Article::where('art_id', $request->input('id'))->first();
        return response ()->json($article);
    }
}
