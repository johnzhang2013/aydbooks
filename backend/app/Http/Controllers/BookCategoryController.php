<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\BookService;

class BookCategoryController extends CommonController
{
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

        $book_categories = $this->bs_instance->listBookCategory($conditions, $paginate);
        if($book_categories->total() > 0){
            foreach($book_categories as $_cate){
                $_tmp_cate = [];

                $_tmp_cate['id'] = $_cate->id;
                $_tmp_cate['name'] = $_cate->name;
                $_tmp_cate['books_total'] = $_cate->books()->count();

                $lists['data']['list'][] = $_tmp_cate;
            }

            $lists['data']['total'] = $book_categories->total();
            $lists['data']['total_page'] =  ceil($book_categories->total() / $paginate['limit']);

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

        $allowed_conditions = ['name'];
        foreach($filters as $_fk => $_fv){
            if(in_array($_fk, $allowed_conditions)){
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
}
