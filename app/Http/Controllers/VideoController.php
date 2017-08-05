<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Band;
use App\BandVideo;
use App\Video;

class VideoController extends Controller
{	
    public function addVideo(Request $request, $bname)
    {
    	$band = Band::where('band_name' , $bname)->first();

        $desc = $request->input('video_desc');
        $videos = $request->file('video_content');
        
        foreach ($videos as $video)
        {
            $videoPath = $this->addPathforVideos($video);

            $create = Video::create([
               'video_desc' => $desc,
                'video_content' => $videoPath,
            ]);

            $bandvideo = BandVideo::create([
            	'band_id' => $band->band_id,
            	'video_id' => $create->video_id,
            ]);
        }
        
        return redirect('/'.$band->band_name);
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
    public function editVideo($bname, $vid)
    {  
        $band = Band::where('band_name', $bname)->first();
        $video = Video::where('video_id', $vid)->first();


        return view('edit-band-video', compact('band' , 'video'));
    }
    public function updateVideo(Request $request, $bname)
    {
        $id = $request->input('video_id');
        $band = Band::where('band_name' , $bname)->first();
        $desc = $request->input('video_desc');

        $update = Video::where('video_id' , $id)->update([
            'video_desc' => $desc,
            ]);

        return redirect('/'.$bname);
    }
    public function deleteVideo($bname, $vid)
    {
        $delete = Video::where('video_id', $vid)->delete();
        return redirect('/'.$bname);
    }

}
