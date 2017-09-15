<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Team extends  Authenticatable
{
    use Notifiable;
    //
    protected $fillable=[
        'team_name',
        'password',
        'topic_id',
        'team_id',
        'domain_id'
    ];
    public $timestamps=false;
    public function members()
    {
        return $this->hasMany('App\Member');
    }

}
