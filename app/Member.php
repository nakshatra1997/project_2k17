<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $fillable=[
        'name',
        'email',
        'course',
        'year',
        'college_name',
        'student_no',
        'contact_no',
        'accomodation',
        'teamlead'
        ];
    public $timestamps=false;

}
