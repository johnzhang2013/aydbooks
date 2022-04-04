<?php

namespace App\Http\Controllers;
use App\Service\BookService;
use Illuminate\Http\Request;
use App\Service\AuthService;

use App\Traits\BookCommonTrait;

class BookController extends CommonController
{
    use BookCommonTrait;
    
    private $bs_instance = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct()
    {
        $this->bs_instance = BookService::getInstance();
    }

    //return the basic data
    public function basics(Request $request){
        $book_options = $this->bs_instance->loadBookBasics();

        return response()->json($book_options);
    }

    public function borrow(Request $request){
        $isbn = $request->isbn;

        //get the member who is borrowing a book
        $member = AuthService::getInstance()->user();
        $member_id = $member->id;

        $borrow_res = $this->bs_instance->borrowBook($member_id, $isbn);
        return response()->json($borrow_res);
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

        $sys_book_basics = $this->bs_instance->loadBookBasics();
        $sys_book_basics = $this->buildBookOptions($sys_book_basics);
        //DB::enableQueryLog();
        $books = $this->bs_instance->listBook($conditions, $paginate);
        //$listsql = DB::getQueryLog();

        if($books->total() > 0){
            foreach($books as $_book){
                $_tmp_book = [];

                $_tmp_book['isbn'] = $_book->isbn;
                $_tmp_book['title'] = $_book->title;
                $_tmp_book['brief_intro'] = $_book->brief_intro;
                $_tmp_book['author'] = $sys_book_basics['authors'][$_book->author_id];
                $_tmp_book['category'] = $sys_book_basics['bookcategories'][$_book->category_id];
                $_tmp_book['stock'] = $_book->stock;
                $_tmp_book['borrowed_count'] = $_book->borrowed_count;                
                $_tmp_book['overdued_count'] = $_book->overdued_count;  
                $_tmp_book['onshelf_datetime'] = $_book->onshelf_datetime;               
                $_tmp_book['is_active'] = $_book->is_active;

                $lists['data']['list'][] = $_tmp_book;
            }

            $lists['data']['total'] = $books->total();
            $lists['data']['total_page'] =  ceil($books->total() / $paginate['limit']);

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

        $allowed_conditions = ['isbn', 'title','category_id', 'author_id', 'onshelf_datetime'];
        foreach($filters as $_fk => $_fv){
            if(in_array($_fk, $allowed_conditions)){
                if($_fk == 'isbn'){
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

                if($_fk == 'onshelf_datetime'){
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
