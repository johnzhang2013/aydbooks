<?php
namespace App\Service;

use App\Repositories\Author as AuthorRepository;

class AuthorService{
	private static $_instance;
	private $_result = null;
	private $ar_instance = null;

	//provent the object to be cloned
	private function __clone(){}
	private function __construct(){
		$this->_result = [
        	'status' => false,
        	'code' => 200,
        	'msg' => null,
        	'data' => null
        ];

		$this->ar_instance = AuthorRepository::getInstance();
	}

	//Singleton use
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	public function loadAuthor($author_name = ''){
		return $this->ar_instance->loadAuthor($author_name);
	}

	public function createAuthor($author_data = []){
		return $this->ar_instance->createAuthor($author_data);
	}

	public function list($filters = [], $paginate = []){
		return $this->ar_instance->list($filters, $paginate);
	}
}
