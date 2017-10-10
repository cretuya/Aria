<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Band;
use App\BandArticle;
use App\Article;

class ArticleController extends Controller
{
	public function bandarticles(Request $request)
	{
		$band = BandArticle::where('band_id', $request->input('band_id'))->get();
		$articles = Array();

		foreach ($band as $article)
		{
			$art = Article::where('art_id', $article->art_id)->first();
			array_push($articles, $art);
		}

		return response ()->json($articles);
	}

    public function addArticle(Request $request)
    {
    	$band = Band::where('band_id', $request->input('band_id'))->first();
        $title = $request->input('art_title');
        $content = $request->input('content');
        
        $create = Article::create([
            'art_title' => $title,
            'content' => $content,
        ]);

        $createBandArticle = BandArticle::create([
        	'band_id' => $band->band_id,
        	'art_id' => $create->art_id , 
        ]);
        return response ()->json (['article' => $create, 'bandarticle' => $createBandArticle]);
    }

    public function viewArticle(Request $request)
    {
        $bart = BandArticle::where('art_id', $request->input('art_id'))->first();
        $article = Article::where('art_id', $bart->art_id)->first();

		return response ()->json ($article);
    }

    public function deleteArticle(Request $request)
    {
        $art = BandArticle::where('art_id', $request->input('art_id'))->first();
        $bid = $art->band_id;
        $band = Band::where('band_id', $bid)->first();

        $delete = Article::where('art_id', $art->art_id)->delete();

        return response ()->json ($delete);
    }

    public function editArticle(Request $request)
    {
        $bart = BandArticle::where('art_id', $request->input('art_id'))->first();
        $art = Article::where('art_id', $bart->art_id)->first();

        return response ()->json ($art);
    }
    public function updateArticle(Request $request)
    {
        $article = BandArticle::where('art_id', $request->input('art_id'))->first();
        $title = $request->input('art_title');
        $content = $request->input('content');

        $update = Article::where('art_id', $article->art_id)->update([
            'art_title' => $title,
            'content' => $content,
        ]);
        return response ()->json ($update);
    }
    public function getArticle(Request $request)
    {
        $article = Article::where('art_id', $request->input('art_id'))->first();
        return response ()->json($article);
    }    
    public function articles()
    {
        $articles = Article::all();

        if (count($articles) > 0)
        {
           return response() ->json($articles);            
        }
        else
        {
            return response() ->json(['message' => 'No articles in the table.']);   
        }
    }
}
