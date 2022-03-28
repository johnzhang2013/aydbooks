<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\AuthorService;

class AuthorController extends CommonController
{
    private $as_instance = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct()
    {
        $this->as_instance = AuthorService::getInstance();
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

        $authors = $this->as_instance->list($conditions, $paginate);
        if($authors->total() > 0){
            foreach($authors as $_author){
                $_tmp_author = [];

                $_tmp_author['id'] = $_author->id;
                $_tmp_author['name'] = $_author->name;                         
                $_tmp_author['books_total'] = $_author->books()->count();

                $lists['data']['list'][] = $_tmp_author;
            }

            $lists['data']['total'] = $authors->total();
            $lists['data']['total_page'] =  ceil($authors->total() / $paginate['limit']);

            $lists['status'] = true;
            $lists['code'] = 200;
        }else{
            $lists['status'] = true;
            $lists['code'] = 404;
            $lists['msg'] = 'No any records matched';
        }

        return response()->json($lists);
    }

    public function books(Request $request){

    }

    public function create(Request $request){

    }

    public function edit(Request $request){

    }

    private function generateQueryConditions($filters = []){
        $conditions = [];

        $allowed_conditions = ['name'];
        foreach($filters as $_fk => $_fv){
            if(in_array($_fk, $allowed_conditions)){
                if($_fk == 'title'){
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
