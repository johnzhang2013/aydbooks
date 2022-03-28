<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\MemberService;

class MemberController extends CommonController
{
    private $ms_instance = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct()
    {
        $this->ms_instance = MemberService::getInstance();
    }
    
    public function list(Request $request){

    }

    public function books(Request $request){

    }

    public function create(Request $request){

    }

    public function edit(Request $request){
        
    }
}
