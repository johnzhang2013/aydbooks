<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\BookService;
use App\Service\MemberService;
use App\Traits\BookCommonTrait;

class BorrowReturnController extends CommonController
{
    use BookCommonTrait;

    private $bs_instance = null;
    private $ms_instance = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct()
    {
        $this->bs_instance = BookService::getInstance();
        $this->ms_instance = MemberService::getInstance();
    }

    public function members(){
        $members_result = [];
        $members_result['status'] = true;
        $members_result['code'] = 200;
        $members_result['msg'] = true;
        $members_result['data'] = $this->ms_instance->loadAllMembers();

        return response()->json($members_result);
    }

    public function list(Request $request){
        $conditions = $this->generateQueryConditions($request->all());
        $paginate = $this->generateQueryPaginate($request->all());

        $lists = [];
        $lists['data'] = [];
        $lists['msg'] = null;
        $lists['data']['list'] = [];

        $lists['data']['total'] = 0;
        $lists['data']['total_page'] = 0;
        $lists['data']['per_page'] = $paginate['limit'];
        $lists['data']['curr_page'] = $paginate['offset'];

        $brrs = $this->bs_instance->listBorrowReturnRecords($conditions, $paginate);

        if($brrs->total() > 0){
            foreach($brrs as $_brr){
                $_tmp_brr = [];

                $_tmp_brr['record_no'] = $_brr->record_no;
                $_tmp_brr['member_name'] = $_brr->member->name;
                $_tmp_brr['book_isbn'] = $_brr->book_isbn;
                $_tmp_brr['book_title'] = $_brr->book_title;

                $_tmp_brr['status'] = $this->displayBorrowReturnStatus($_brr->status);
                $_tmp_brr['deadline_daysleft'] = $this->calcDeadlineDaysLeft($_brr->status, $_brr->borrowed_datetime, $_brr->deadline_datetime);

                $_tmp_brr['overdued_days'] = ($_brr->overdued_days == 0) ? '-' : $_brr->overdued_days;
                $_tmp_brr['deadline_datetime'] = ($_brr->deadline_datetime == null) ? '-' : $_brr->deadline_datetime;
                $_tmp_brr['borrowed_datetime'] = ($_brr->borrowed_datetime == null) ? '-' : $_brr->borrowed_datetime;
                $_tmp_brr['returned_datetime'] = ($_brr->returned_datetime == null) ? '-' : $_brr->returned_datetime;

                $lists['data']['list'][] = $_tmp_brr;
            }

            $lists['data']['total'] = $brrs->total();
            $lists['data']['total_page'] =  ceil($brrs->total() / $paginate['limit']);

            $lists['status'] = true;
            $lists['code'] = 200;
        }else{
            $lists['status'] = true;
            $lists['code'] = 404;
            $lists['msg'] = 'No any records matched';
        }

        return response()->json($lists);
    }

    private function generateQueryConditions($filters = []){
        $conditions = [];

        $allowed_conditions = ['record_no','book_isbn', 'book_title','user_id', 'status', 'borrowed_datetime', 'returned_datetime', 'deadline_datetime'];

        foreach($filters as $_fk => $_fv){
            if(in_array($_fk, $allowed_conditions)){
                if($_fk == 'record_no' || $_fk == 'book_isbn'){
                    if(trim($_fv) == null || empty(trim($_fv))){
                        continue;
                    }else{
                        $conditions[] = [$_fk, '=', trim($_fv)];
                    }
                }

                if($_fk == 'status' || $_fk == 'user_id'){
                    if($_fv == -1 || $_fv === null){//All options
                        continue;
                    }else{
                        $conditions[] = [$_fk, '=', trim($_fv)];
                    }
                }


                if($_fk == 'book_title'){
                    if(trim($_fv) == null || empty(trim($_fv))){
                        continue;
                    }else{
                        $conditions[] = [$_fk, 'like', trim($_fv)];
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
}
