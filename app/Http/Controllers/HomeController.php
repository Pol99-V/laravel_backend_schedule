<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\Schedule;
use App\ScheduleEvent;
use App\AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $fcm_key = 'AAAAyvdxyDM:APA91bFDozaCSAnmxLr2eK4dDGeT022CWF4uqsuPbMaZUJMi_CFp4JyoyyGWQM2ZJnzB1L0kzrL8mfadf1E_mNCMmre8hwKFgQOOeaR0FhgRuselMVvhhIhxJp7yL_cldXN2i0eABIV9';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        return view('schedule_page');
    }
    
    public function schedule_page()
    {
        $events = ScheduleEvent::all()->sortBy('created_at');
        $schedules = DB::table('schedules') 
                            ->join('schedule_events', 'schedules.schedule_event_id', '=', 'schedule_events.id')
                            ->select(
                                'schedules.*',
                                'schedule_events.title',
                                'schedule_events.color'                               
                            )->get();

        return view('schedule_page', [
            'events'    => $events,
            'schedules' => $schedules
        ]);
    }

    public function createScheduleEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'color' => 'required|string'
        ]);
        $validator->validate();

        $event = new ScheduleEvent;
        $result = $event->create([
            'title' => $request['title'],
            'color' => $request['color']
        ]);
        
        return response()->json(['result' => $result], 200);
    }

    public function deleteScheduleEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:schedule_events',
        ]);
        $validator->validate();

        $event = ScheduleEvent::find($request['id']);
        if ($event == NULL) {
            throw ValidationException::withMessages([
                'event' => [trans('error.invalid_event')],
            ]);
        }
        $event->delete();

        return response()->json(['id' => $request['id']], 200);
    }

    public function createSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'schedule_event_id' => 'required|string',
            'start' => 'required|string',
            'end' => 'required|string',
            'dayOfWeek' => 'required|string'
        ]);
        $validator->validate();

        $schedule = new Schedule;
        $result = $schedule->create([
            'id' => $request['id'],
            'schedule_event_id' => $request['schedule_event_id'],
            'start' => $request['start'],
            'end' => $request['end'],
            'dayOfWeek' => $request['dayOfWeek']
        ]);
        
        return response()->json(['result' => $result], 200);
    }

    public function deleteSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|exists:schedules',
        ]);
        $validator->validate();

        $schedule = Schedule::find($request['id']);
        if ($schedule == NULL) {
            throw ValidationException::withMessages([
                'schedule' => [trans('error.invalid_schedule')],
            ]);
        }
        $schedule->delete();

        return response()->json(['id' => $request['id']], 200);
    }

    public function updateSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'start' => 'required|string',
            'end' => 'required|string',
            'dayOfWeek' => 'required|string'
        ]);
        $validator->validate();

        $schedule = Schedule::find($request['id']) ;
        $result = $schedule->update([
            'start' => $request['start'],
            'end' => $request['end'],
            'dayOfWeek' => $request['dayOfWeek']
        ]);
        
        return response()->json(['result' => $result], 200);
    }

    public function push_notification()
    {
        return view('push_notification');
    }

    public function pushNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string'
        ]);
        $validator->validate();

        $title = $request['title'];
        $content = $request['content'];
        // $test_tocken = 'fVBw2XpD524:APA91bHzyZ0arNrUsluQ2xD-WSpiUqTbg52LUi8r73bJ1-YHuER3wxEza4Kh9tZImYWV1PD4G1eecXWpgAV3-Yh76VeianiPJPY_FmbzUbkGAaAkmriihlDc2vlTf5bu3hXl5D4FaGLQ';
        // $result = $this->notification($test_tocken, $title, $content);
        $data = array();
        $tockens = AppUser::all();
        foreach ($tockens as $tocken) {
            $data[] = $tocken['tocken'];
        }    
        $result = $this->notification($data, $title, $content);
        return response()->json(['result' => json_decode($result)], 200);
    }

    public function notification($token, $title, $content)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token=$token;

        $notification = [
            'title' => $title,
            'body' => $content,
        ];
        
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'registration_ids'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . $this->fcm_key,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function showChangePasswordForm(){
        return view('auth.passwords.change_password');
    }
    
    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
    }

    public function showEditProfileForm()
    {
        return view('auth.edit_profile');
    }

    public function editProfile(Request $request){

        if(strcmp($request->get('name'), Auth::user()->name) == 0 && strcmp($request->get('email'), Auth::user()->email) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Profile cannot be same as your current Profile. Please choose a different Profile.");
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = Auth::user();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->save();
        return redirect()->back()->with("success","Profile changed successfully !");
    }
}
