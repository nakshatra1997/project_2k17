<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CheckStudentController extends ApiController
{
    //
    public function checkStudentNo($student_no)
    {
        // return 'mayur';
        //if(Member::where('student_no',$request['student_no'])->exists())
        $user = Member::where('student_no', $student_no)->first();
        if($user)
        {

            return $this->errorResponse('This participant already exists',422);
        }
        else
        {

            return $this->errorResponse('This participant does not exist',200);
        }

    }

    public function checkEmail(Request $request)
    {
        $email = Member::where('email', $request->email)->first();
        //dd($email);
        if($email)
        {
            return $this->errorResponse('This email id already exists',422);
        }
        else
        {
            return $this->errorResponse('This email id does not exist',200);
        }

    }
}
