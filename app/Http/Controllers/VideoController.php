<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserNotification;
use App\Band;
use App\BandVideo;
use App\Video;
use Validator;
class VideoController extends Controller
{	

    public function videos($bname)
    {
        $band = Band::where('band_name', $bname)->first();
        $videos = $band->bandvids;
        // dd($videos);
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
        return view('videos', compact('band', 'videos','usernotifinvite'));
    }
    public function addVideo(Request $request, $bname)
    {
    	$band = Band::where('band_name' , $bname)->first();

        $desc = $request->input('video_desc');
        $videos = $request->file('video_content');
        
        $rules = new Video;
        $validator = Validator::make($request->all(), $rules->rules);
        if ($validator->fails())
        {
            return redirect('/'.$band->band_name.'/manage')->withErrors($validator)->withInput();
        }
        else
        {
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
            
            return redirect('/'.$band->band_name.'/manage');
        }
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

        $rules = new Video;
        $validator = Validator::make($request->all(), $rules->updaterules);
        if ($validator->fails())
        {
            return redirect('/'.$band->band_name.'/manage')->withErrors($validator)->withInput();
        }
        else
        {        
            $update = Video::where('video_id' , $id)->update([
                'video_desc' => $desc,
                ]);

            return redirect('/'.$bname.'/manage');
        }
    }
    public function deleteVideo($bname, $vid)
    {
        $delete = Video::where('video_id', $vid)->delete();
        return redirect('/'.$bname.'/manage');
    }

}
