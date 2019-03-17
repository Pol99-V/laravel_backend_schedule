<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\AppUser;

class PushController extends Controller
{
    public function putDeviceTocken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tocken' => 'required|string|unique:app_users'
        ]);
        if ($validator->fails()) {
            return response()->json(['result' => 'Validation Error'], 400);
        }

        $user = new AppUser;
        $result = $user->create([
            'tocken' => $request['tocken']
        ]);
        
        return response()->json(['result' => $result], 200);
    }
    public function getSchedule($id)
    {
        $validator = Validator::make(
        [ 'id' => $id ],
        [ 'id' => ['required', 'integer', 'between:0,6'] ]);
        if ($validator->fails()) {
            return response()->json(['result' => 'Validation Error'], 400);
        }

        $schedules = DB::table('schedules') 
                        ->where('dayOfWeek', '=', (intval($id) + 1) % 7 )
                        ->join('schedule_events', 'schedules.schedule_event_id', '=', 'schedule_events.id')
                        ->select(
                            'schedules.start',
                            'schedules.end',
                            'schedule_events.title'                              
                        )->get();

        $result = array();
        foreach ($schedules as $schedule) {
            $result[] = array(
                'start' => $schedule->start,
                'end' => $schedule->end,
                'title' => $schedule->title
            ); 
        }

        return response()->json(['result' => $result], 200);
    }
}
