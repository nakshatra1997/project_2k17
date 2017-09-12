<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    public function domain()
    {
        return $this->hasOne("App\Domain","id","domain_id");
    }
}
