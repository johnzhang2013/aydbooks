<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\MemberService;
use App\Service\AuthService;
use App\Service\BookService;

use App\Traits\BookCommonTrait;

class MemberController extends CommonController
{
    use BookCommonTrait;

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
        $conditions = $this->generateQueryConditions($request->all());
        $paginate = $this->generateQueryPaginate($request->all());

        $lists = [];
        $lists['data'] = [];
        $lists['data']['list'] = [];

        $lists['data']['total'] = 0;
        $lists['data']['total_page'] = 0;
        $lists['data']['per_page'] = $paginate['limit'];
        $lists['data']['curr_page'] = $paginate['offset'];

        $members = MemberService::getInstance()->list($conditions, $paginate);
        if($members->total() > 0){
            foreach($members as $_member){
                $_tmp_member = [];

                $_tmp_member['id'] = $_member->id;
                $_tmp_member['name'] = $_member->name;
                $_tmp_member['email'] = $_member->email;
                $_tmp_member['is_active'] = $_member->is_active;
                $_tmp_member['lendable_qty'] = $_member->lendable_qty;

                //calculate the borrow return records count of this member
                $_tmp_brr_count = $this->buildMembersBRRCount($_member);

                $_tmp_member['borrowing_normal_total'] = $_tmp_brr_count['borrowing_normal'];
                $_tmp_member['borrowing_overdued_total'] = $_tmp_brr_count['borrowing_overdued'];
                $_tmp_member['returned_normal_total'] = $_tmp_brr_count['returned_normal'];
                $_tmp_member['returned_overdued_total'] = $_tmp_brr_count['returned_overdued'];

                $lists['data']['list'][] = $_tmp_member;
            }

            $lists['data']['total'] = $members->total();
            $lists['data']['total_page'] =  ceil($members->total() / $paginate['limit']);

            $lists['status'] = true;
            $lists['code'] = 200;
        }else{
            $lists['status'] = false;
            $lists['code'] = 400;
        }

        return response()->json($lists);
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

    public function borrowReturnRecords(Request $request){        
        $paginate = $this->generateQueryPaginate($request->all());

        $brr_lists = [
            'status' => true,
            'code' => 200,
            'msg' => null,
            'data' => null
        ];

        $brr_lists['data'] = [];
        $brr_lists['data']['list'] = [];

        $brr_lists['data']['total'] = 0;
        $brr_lists['data']['total_page'] = 0;
        $brr_lists['data']['per_page'] = $paginate['limit'];
        $brr_lists['data']['curr_page'] = $paginate['offset'];

        //step1 - Get the logged user
        $member = AuthService::getInstance()->user();
        if($member == null){
            $brr_lists['status'] = false;
            $brr_lists['code'] = 404;
            $brr_lists['msg'] = trans('profile.no_brr');

            return response()->json($brr_lists);
        }
        $member_id = $member->id;//only get the borrow return records of this member

        $sys_book_basics = BookService::getInstance()->loadBookBasics();
        $sys_book_basics = $this->buildBookOptions($sys_book_basics);

        $conditions = $this->generateQueryConditionsForMemberBRR($member_id, $request->all());
        $brrs = $this->ms_instance->listBorrowReturnRecords($conditions, $paginate);
        if($brrs->total() > 0){
            foreach($brrs as $_brr){
                $_tmp_brr = [];

                $_tmp_brr['record_no'] = $_brr->record_no;
                $_tmp_brr['isbn'] = $_brr->book_isbn;
                $_tmp_brr['title'] = $_brr->book_title;
                $_tmp_brr['status'] = $this->displayBorrowReturnStatus($_brr->status);
                
                $_tmp_brr['overdued_days'] = $_brr->overdued_days;

                $_tmp_brr['deadline_datetime'] = $_brr->deadline_datetime;
                $_tmp_brr['borrowed_datetime'] = $_brr->borrowed_datetime;
                $_tmp_brr['returned_datetime'] = $_brr->returned_datetime;

                $brr_lists['data']['list'][] = $_tmp_brr;
            }

            $brr_lists['data']['total'] = $brrs->total();
            $brr_lists['data']['total_page'] =  ceil($brrs->total() / $paginate['limit']);

            $brr_lists['status'] = true;
            $brr_lists['code'] = 200;
        }else{
            $brr_lists['status'] = true;
            $brr_lists['code'] = 404;
            $brr_lists['msg'] = trans('profile.no_brr');
        }

        return response()->json($brr_lists);
    }

    //This is for borrow return reocrds of one specific member 
    private function generateQueryConditionsForMemberBRR($member_id = null ,$filters = []){
        $conditions = [];
        $conditions[] = ['user_id', '=', $member_id];//

        $allowed_conditions = ['record_no', 'isbn', 'title','category_id', 'author_id', 'borrowed_datetime', 'returned_datetime', 'deadline_datetime', 'status'];
        foreach($filters as $_fk => $_fv){
            if(in_array($_fk, $allowed_conditions)){
                if($_fk == 'record_no'){
                    if(trim($_fv) == null || empty(trim($_fv))){
                        continue;
                    }else{
                        $conditions[] = [$_fk, '=', trim($_fv)];
                        break;//as this is an unique value,so no need to use other filters
                    }
                }

                if($_fk == 'isbn' || $_fk == 'status'){
                    if(trim($_fv) == null || empty(trim($_fv))){
                        continue;
                    }else{
                        $conditions[] = [$_fk, '=', trim($_fv)];
                    }
                }

                if($_fk == 'title'){
                    if(trim($_fv) == null || empty(trim($_fv))){
                        continue;
                    }else{
                        $conditions[] = [$_fk, 'like', trim($_fv)];
                    }
                }

                if($_fk == 'category_id' || $_fk == 'author_id'){
                    if($_fv == 0){//All options
                        continue;
                    }else{
                        $conditions[] = [$_fk, '=', trim($_fv)];
                    }
                }

                if($_fk == 'borrowed_datetime' || $_fk == 'returned_datetime' || $_fk == 'deadline_datetime'){
                    if($_fv == null || empty($_fv)) continue;
                    
                    if(is_array($_fv)){//date range
                        if(isset($_fv[0]) && isset($_fv[1])){
                            $date_pattern = '/^\d{4}\-\d{1,2}\-\d{1,2}$/';
                            if(!preg_match($date_pattern, $_fv[0]) || !preg_match($date_pattern, $_fv[1])){
                                continue;
                            }else{
                                $conditions[] = [$_fk, '>=', trim($_fv[0])];
                                $conditions[] = [$_fk, '<=', trim($_fv[1])];
                            }
                        }
                    }                    
                }                
            }
        }

        return $conditions;
    }

    //This is for one specific member profile
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

    //This is for members list
    private function generateQueryConditions($filters = []){
        $conditions = [];
        $allowed_conditions = ['email', 'name'];

        foreach($filters as $_fk => $_fv){
            if(in_array($_fk, $allowed_conditions)){
                if($_fk == 'email'){
                    if(trim($_fv) == null || empty(trim($_fv))){
                        continue;
                    }else{
                        $conditions[] = [$_fk, '=', trim($_fv)];
                    }
                }

                if($_fk == 'name'){
                    if(trim($_fv) == null || empty(trim($_fv))){
                        continue;
                    }else{
                        $conditions[] = [$_fk, 'like', trim($_fv)];
                    }
                }
            }
        }

        return $conditions;
    }

    //This is for members list 
    private function buildMembersBRRCount($member = null) {
        $book_cfg = config('books.borrowed_status');
        $brr_records = $member->borrow_return_records;

        $brr_count = [
            'all_total' => 0,
            'borrowing_normal' => 0,
            'borrowing_overdued' => 0,
            'returned_normal' => 0, 
            'returned_overdued' => 0
        ];

        $brr_total = $brr_records->count();
        if($brr_total == 0) return $brr_count;

        $brr_borrowing_normal = 0;
        $brr_borrowing_overdued = 0;
        $brr_returned_normal = 0;
        $brr_returned_overdued = 0;

        foreach($brr_records as $_brr){
            if($_brr->status == $book_cfg['BeBorrowingNormal']){
                $brr_borrowing_normal++;
            }else if($_brr->status == $book_cfg['BeBorrowingOverdued']){
                $brr_borrowing_overdued++;
            }else if($_brr->status == $book_cfg['BeReturnedNormal']){
                $brr_returned_normal++;
            }else{
                $brr_returned_overdued++;
            }
        }
        
        $brr_count = [
            'all_total' => $brr_total,
            'borrowing_normal' => $brr_borrowing_normal,
            'borrowing_overdued' => $brr_borrowing_overdued,
            'returned_normal' => $brr_returned_normal, 
            'returned_overdued' => $brr_returned_overdued
        ];

        return $brr_count;
    }
}
