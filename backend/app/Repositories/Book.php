<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Models\Book as BookModel;
use App\Models\BookCategory as BookCategoryModel;
use App\Models\BorrowReturnRecord as BRRModel;

class Book{
	private static $_instance;

	//provent the object to be cloned
	private function __clone(){}
	private function __construct(){}

	//Singleton use
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	#####################################################
	public function createBook($b_data = []){
		return $this->_createEntity('BookModel', $b_data);
	}

	public function createBookCategory($bc_data = []){
		return $this->_createEntity('BookCategoryModel', $bc_data);
	}

	public function createBorrowReturnRecord($brr_data = []){
		return $this->_createEntity('BRRModel', $brr_data);
	}

	public function loadBookCategory($cid = 0){
		return BookCategoryModel::find($cid);
	}
    
    public function loadBookCategoryByName($cate_name = ''){
    	return BookCategoryModel::Where('name', $cate_name)->first();
    }

    public function loadBookCategories(){
        return BookCategoryModel::all();
    }

    public function loadBook($book_id = 0){
    	return BookModel::find($book_id);
    }

    public function loadBookByISBN($isbn = ''){
    	return BookModel::Where('isbn', $isbn)->first();
    }

    public function listBook($filters = [], $paginate = []){
    	if(empty($filters)){
    		return BookModel::paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
    	}else{
    		return BookModel::where($filters)->paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
    	}
    }

    public function listBookCategory($filters = [], $paginate = []){
    	if(empty($filters)){
    		return BookCategoryModel::paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
    	}else{
    		return BookCategoryModel::where($filters)->paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
    	}
    }

    public function listTopBorrowedCountBooks($n = 10){
    	return BookModel::OrderBy('borrowed_count', 'desc')->orderBy('id', 'asc')->limit($n)->get();
    }

    public function listTopOverduedCountBooks($n = 10){
    	return BookModel::OrderBy('overdued_count', 'desc')->orderBy('id', 'asc')->limit($n)->get();
    }
    
    public function listTopBorrowedCountBookCategories($n = 10){
    	return BookModel::Select('category_id', DB::raw('sum(borrowed_count) as cate_borrowed_count'))
    					->GroupBy('category_id')
    					->orderBy('cate_borrowed_count', 'desc')
    					->limit($n)
    					->get();
    }

    public function listTopOverduedCountBookCategories($n = 10){
    	return BookModel::Select('category_id', DB::raw('sum(overdued_count) as cate_overdued_count'))
    					->GroupBy('category_id')
    					->orderBy('cate_overdued_count', 'desc')
    					->limit($n)
    					->get();
    }


    //Calc the stock sum of all books
    public function allStockSum(){
    	return BookModel::allStockSum();
    }

    //Calc all borrowing out(not returned)
    public function allBorrowingCount(){
    	$all_borrowing_normal_cnt = $this->allBorrowingNormalCount();
    	$all_borrowing_overdued_cnt = $this->allBorrowingOverduedCount();

    	return $all_borrowing_normal_cnt + $all_borrowing_overdued_cnt;
    }

    //All borrowing out(normal)
    public function allBorrowingNormalCount(){
    	$book_cfg = config('books.borrowed_status');

    	return BRRModel::where('status',$book_cfg['BeBorrowingNormal'])->count();
    }
    //All borrowing out(overdued)
    public function allBorrowingOverduedCount(){
    	$book_cfg = config('books.borrowed_status');

    	return BRRModel::where('status',$book_cfg['BeBorrowingOverdued'])->count();
    }

    ######################################################
	private function _createEntity($entity_model = '', $entity_data = []){
		DB::beginTransaction();

		try{
			$entity = $this->_createEntityTransaction($entity_model, $entity_data);
			if($entity == null){//business logic error
				DB::rollBack();
			}else{
				DB::commit();
			}
			return $entity;
		}catch(\Exception $e){//DB exception
			DB::rollBack();
			return null;
		}
	}
	private function _createEntityTransaction($entity_model = '', $entity_data = []){
		switch(true){
			case $entity_model == 'BookModel':
				$entity = new BookModel();
			break;
			case $entity_model == 'BookCategoryModel':
				$entity = new BookCategoryModel();
			break;
			case $entity_model == 'BRRModel':
				$entity = new BRRModel();
			break;
			default:
				return null;
			break;
		}

		foreach($entity_data as $k => $v){
			$entity->$k = $v;
		}
		$res = $entity->save();

		return ($res == true) ? $entity : null;
	}
}