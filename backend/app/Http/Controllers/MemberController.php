<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\MemberService;
use App\Service\AuthService;

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

    public function profile(Request $request){
        $profile = [
            'status' => true,
            'code' => 200,
            'msg' => null,
            'data' => null
        ];

        //step1 - Get the logged user
        $member = AuthService::getInstance()->user();
        if($member == null){
            $profile['status'] = false;
            $profile['code'] = 404;
            $profile['msg'] = trans('profile.no_user');

            return response()->json($profile);
        }

        $brr_count = $this->buildMemberBRRCount($member);

        $profile['data'] = [];
        $profile['data']['name'] = $member->name;
        $profile['data']['email'] = $member->email;
        $profile['data']['lendable_qty'] = $member->lendable_qty;
        $profile['data']['is_active'] = ($member->is_active == 1) ? trans('profile.is_active_yes') : trans('profile.is_active_no');
        $profile['data']['brr_count'] = $brr_count;

        return response()->json($profile);
    }

    private function buildMemberBRRCount($member = null){
        $book_cfg = config('books.borrowed_status');
        $brr_records = $member->borrow_return_records;

        $brr_total = $brr_records->count();
        if($brr_total == 0) return 0;

        $brr_no_returns = 0;
        foreach($brr_records as $_brr){
            if($_brr->status == $book_cfg['BeBorrowingNormal'] || $_brr->status == $book_cfg['BeBorrowingOverdued']){
                $brr_no_returns++;
            }
        }
        
        if($brr_no_returns == 0) return 0;

        return $brr_no_returns.'/'.$brr_total;
    }
}
