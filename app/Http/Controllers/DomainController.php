<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;

class DomainController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $domain = Domain::all();
        return $this->showAll($domain);
    }

   public function specificTopic($id)
   {
       $domain=Domain::find($id);
       return $this->showAll($domain->topics);

   }
}
