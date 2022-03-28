<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Models\Author as AuthorModel;

class Author{
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

	public function createAuthor($a_data = []){
		return $this->_createEntity('AuthorModel', $a_data);
	}

	public function loadAuthor($name = ''){
		return AuthorModel::Where('name', $name)->first();
	}
    
    public function loadAuthors(){
        return AuthorModel::all();
    }

    public function list($filters = [], $paginate = []){
    	if(empty($filters)){
    		return AuthorModel::paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
    	}else{
    		return AuthorModel::where($filters)->paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
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
			case $entity_model == 'AuthorModel':
				$entity = new AuthorModel();
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