<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $fillable=[
        'team_name',
        'password',
        'topic_id'
    ];
    public $timestamps=false;
}
