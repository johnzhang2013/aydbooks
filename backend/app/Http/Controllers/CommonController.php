<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    //
    protected function generateQueryPaginate($filters = []){
        $paginate = [];

        if(!isset($filters['curr_page']) || !is_numeric($filters['curr_page']) || $filters['curr_page'] < 1){
            $paginate['offset'] = 1;
        }else{
            $paginate['offset'] = intval($filters['curr_page']);
        }

        if(!isset($filters['per_page']) || !is_numeric($filters['per_page']) || $filters['per_page'] < 1){
            $paginate['limit'] = 10;
        }else{
            $paginate['limit'] = intval($filters['per_page']);
        }

        return $paginate;
    }
}
