<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Band;
use App\BandVideo;
use App\Video;


class VideoController extends Controller
{

    public function bandvideos(Request $request)
    {
        $band = BandVideo::where('band_id', $request->input('band_id'))->get();
        $vids = Array();
        foreach ($band as $video)
        {
            $id = $video->video_id;
            $vid = Video::where('video_id', $id)->first();
            array_push($vids, $vid);
        }

        return response ()->json($vids);
    }


    public function addVideo(Request $request)
    {
        $band = Band::where('band_id' , $request->input('band_id'))->first();
        $title = $request->input('video_title');
            $desc = $request->input('video_desc');
            $video = $request->file('video_content');
        
                $videoPath = $this->addPathforVideos($video);

                $create = Video::create([
                   'video_title' => $title,
                   'video_desc' => $desc,
                    'video_content' => $videoPath,
                ]);

                $bandvideo = BandVideo::create([
                    'band_id' => $band->band_id,
                    'video_id' => $create->video_id,
                ]);
                
            return response ()->json ($create);
        

    }
    
    public function addPathforVideos($video)
    {
        if ($video != null)
        {
            $extension = $video->getClientOriginalExtension();
            if ($extension != "bin")
            {
                $destinationPath = public_path().'/assets/video/';
                $filename = $video->getClientOriginalName();
                $video->move($destinationPath, $filename);
                $video = $filename; 
            }
        }
        else
        {
            $video = "";
        }
        return $video;
    }
    public function editVideo(Request $request)
    {  
        $band = Band::where('band_id', $request->input('band_id'))->first();
        $video = Video::where('video_id',$request->input('video_id'))->first();


        return response ()->json (['band' => $band, 'video' => $video]);
    }

    public function updateVideo(Request $request)
    {
            $band = Band::where('band_id' , $request->input('band_id'))->first();

            $id = $request->input('video_id');
            $desc = $request->input('video_desc');

            $update = Video::where('video_id' , $id)->update([
                'video_desc' => $desc,
                ]);

            return response()->json($update);
    }

    public function deleteVideo(Request $request)
    {
        $delete = Video::where('video_id', $request->input('video_id'))->delete();
        return response ()->json($delete);
    }

    public function videos()
    {
        $videos = Video::all();

        return response() ->json($videos);
    }

}
