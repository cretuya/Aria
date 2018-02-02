<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Band;
use App\BandEvent;
use DateTime;

class EventController extends Controller
{
    public function addEvent(Request $request)
    {
        $band = Band::where('band_id', $request->input('event_band_id'))->first();
        $bandID = $request->input('event_band_id');
        $eventName = $request->input('event_name');
        $date = $request->input('event_date');
        $time = $request->input('event_time');
        $eventVenue = $request->input('event_venue');
        $eventLocation = $request->input('event_location');

        // $band = Band::where('band_id', $request->input('band_id'))->first();

        $eventDate = date('Y-m-d', strtotime(str_replace('-', '/', $date)));

        $toBeFormatTime = DateTime::createFromFormat( 'H:i A', $time);
        $eventTime = $toBeFormatTime->format( 'H:i:s');
    
        $create = BandEvent::create([
            'band_id' => $bandID,
            'event_name' => $eventName,
            'event_date' => $eventDate,
            'event_time' => $eventTime,
            'event_venue' => $eventVenue,
            'event_location' => $eventLocation,
        ]);

        return redirect($band->band_name.'/manage');

    }
}
