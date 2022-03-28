<?php
namespace App\Service;

use App\Repositories\Book as BookRepository;
use App\Repositories\Author as AuthorRepository;

class BookService{
	private static $_instance;
	private $_result = null;
	private $br_instance = null;
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

		$this->br_instance = BookRepository::getInstance();
		$this->ar_instance = AuthorRepository::getInstance();
	}

	//Singleton use
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function loadBookBasics(){
		//For optimization - fetch these data from Cacheware(Redis or Memcache) as they often do not change.

        $authors = $this->ar_instance->loadAuthors();
        $sys_authors_data = [];
        foreach($authors as $_author){
            $sys_authors_data[] = ['label' => $_author->name, 'value' => $_author->id];
        }

        $book_categories = $this->br_instance->loadBookCategories();
        $sys_bookcategories_data = [];
        foreach($book_categories as $_category){
            $sys_bookcategories_data[] = ['label' => $_category->name, 'value' => $_category->id];
        }

        return [
            'sys_authors' => $sys_authors_data,
            'sys_bookcategories' => $sys_bookcategories_data
        ];
	}

	public function listBook($filters = [], $paginate = []){
		return $this->br_instance->listBook($filters, $paginate);
	}

	public function listBookCategory($filters = [], $paginate = []){
		return $this->br_instance->listBookCategory($filters, $paginate);
	}
	
	public function createBook($book_data = []){
		return $this->br_instance->createBook($book_data);
	}

	public function createBookCategory($bcate_data = []){
		return $this->br_instance->createBookCategory($bcate_data);
	}

	public function loadBookCategory($cate_name = ''){
		return $this->br_instance->loadBookCategory($cate_name);
	}

	public function borrowBook($borrow_data = []){

	}

	public function returnBook($record_no = ''){

	}
}