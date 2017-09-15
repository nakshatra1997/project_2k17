<?php

namespace App\Http\Controllers;
//use Illuminate\Contracts\Validation\Validator;
use App\Member;
use App\Team;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use  Illuminate\Support\Facades\Hash, Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
class AuthController extends ApiController
{
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        //These rules are done according to the old json
        //updated rules according to the new json are updated in another file named as authcontroller
        $rules = [
            'teamdetails.*.team_name' => 'required|max:50|unique:teams',
            'teamdetails.*.domain_id' => 'required',
            'teamdetails.*.topic_id' => 'required',
            'teamdetails.*.password' => 'required|min:6',
            'members.*.*.*.name' => 'required',
            'members.*.*.*.course' => 'required',
            'members.*.*.*.year' => 'required|max:1',
            'members.*.*.*.student_no' => 'nullable|regex:/^(\d){7}[dD\-"\s"]{0,1}$/|unique:members',
            'members.*.*.*.accomodation' => 'required',
            'members.*.*.*.college_name' => 'required|alpha',
            'members.*.*.*.email' => 'required|email|unique:members',
            'members.*.*.*.contact_no' => 'required|max:11|min:10',
        ];

        $inputs = $request->all();
        $validator = Validator::make($inputs, $rules);

        if($validator->fails()) {
            $error = $validator->messages()->toJson();
            return response()->json(['success'=> false, 'error'=> $error]);
        }
        $input_team=$request->teamdetails;
        $input_member=$request->members[0];
        $topic_id=$input_team[0]['topic_id'];
        $domain_id=$input_team[0]['domain_id'];
        $id='SCROLLS'.$topic_id.$domain_id.rand(10,99).rand(1,9);

        $team_details=[
            'team_name'=>$input_team[0]['team_name'],
            'password'=>Hash::make($input_team[0]['password']),
            'topic_id'=>$topic_id,
            'domain_id'=>$domain_id,
            'team_id'=>$id,
            'noofmembers'=>$input_team[0]['noofmembers']

        ];

       Team::create($team_details);
        $team=Team::where('team_name','=',$team_details['team_name'])->first();

        foreach($input_member
                as $member)
        {

            $mem=[
                'name'=>$member[0]['name'],
                'email'=>$member[0]['email'],
                'course'=>$member[0]['course'],
                'year'=>$member[0]['year'],
                'student_no'=>$member[0]['student_no'],
                'accomodation'=>$member[0]['accomodation'],
                'college_name'=>$member[0]['college_name'],
                'contact_no'=>$member[0]['contact_no'],
                'team_id'=>$team->id,
                'teamlead'=>$member[0]['teamlead']
            ];
            Member::create($mem);
        }
        $team_name=$team_details['team_name'];
        $email_sent=Member::where('teamlead','=','1')->first();
        $email=$email_sent->email;
        $subject = "Team Registration for SCROLLS 2k17";
        Mail::send('email.verify', ['name' => $team_name, 'team_id' => $mem['team_id']],
            function($mail) use ($email, $team_name, $subject){
                $mail->from("nakshatrapradhan2013@gmail.com", "SCROLLS 2k17");
                $mail->to($email,$team_name);
                $mail->subject($subject);
            });
       return response()->json(['success'=> true, 'message'=>$mem['team_id']]);
    }
//NOW LOGIN*********************************************************************************************

    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'team_id' => 'required',
            'password' => 'required',
        ];
        $input = $request->only('team_id', 'password');
        $validator = Validator::make($input, $rules);
               if($validator->fails()) {
            $error = $validator->messages()->toJson();
            return response()->json(['success'=> false, 'error'=> $error]);
        }
        $credentials = [
            'team_id' => $request->team_id,
            'password' => $request->password,
                    ];
        $token = $this->jwt->attempt($credentials);

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = $this->jwt->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Invalid Credentials. Please make sure you entered the right information and you have verified your email address.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => $token ]]);
    }


    //NOW LOGOUT**************************************************************************************************
    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);
        try {
            $this->jwt->invalidate($request->input('token'));
            return response()->json(['success' => true]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }
}