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

    public function loadBookCategory($cate_name = ''){
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