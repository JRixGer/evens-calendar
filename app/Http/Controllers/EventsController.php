<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventsCalendar;

class EventsController extends Controller
{
    public function __construct()
    {
        config(['app.timezone' => 'Asia/Manila']);
    }
    
    public function addEvents(Request $request)
    {
  
        $data = $request->toArray();

        $days = array();
        foreach ($data['day'] as $key => $d) 
        {
            if(!empty($d))
                $days[] = $key; 
        }
        
        $start = strtotime($data['dates']['dtStart']);
        $end = strtotime($data['dates']['dtEnd']);

        $events = array();
        $res = false;
        $i = 0;
        $mess = '';
        if(sizeof($days)>0)
        {
            while ($start < $end)
            {
                if(in_array(date('D',$start), $days)) 
                {
                    $events[$i]['event_description'] = $data['event_description']; 
                    $events[$i]['day_number'] = date('j', $start); 
                    $events[$i]['event_date'] = date('n/j/Y', $start); 
                    $events[$i]['event_day'] = date('D', $start); 
                    $EventsCalendar = new EventsCalendar();
                    $EventsCalendar->event_description = $data['event_description'];
                    $EventsCalendar->event_date = date('Y/n/j', $start);
                    $EventsCalendar->event_day = date('D',$start);
                    $res = $EventsCalendar->save();
                    if(!$res)
                        break;
                }
                else{
                    $events[$i]['day_number'] = date('j', $start); 
                    $events[$i]['event_date'] = date('n/j/Y', $start); 
                    $events[$i]['event_day'] = date('D', $start); 
                    $events[$i]['event_description'] = ''; 
                }
                $i++;
                $start = $start + 86400; 
            }
            if($res)
                return Response()->json(['status' => true, 'mess' => 'Events saved', 'events' => $events]);  
                    else
                return Response()->json(['status' => false, 'mess' => 'Error encountered', 'events' => NULL]);  
    
        }
        else
            return Response()->json(['status' => false, 'mess' => 'No day/s selected', 'events' => NULL]);  


    }
}
