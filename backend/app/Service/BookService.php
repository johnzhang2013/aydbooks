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

	public function creatBookBorrowReturnRecord($brr_data = []){

	}

	public function loadBookCategoryByName($cate_name = ''){
		return $this->br_instance->loadBookCategoryByName($cate_name);
	}

	public function borrowBook($isbn = ''){
		//step1 - check member if qualified
		$member = AuthService::getInstance()->user();
		if($member == null){
			$this->_result['status'] = false;
			$this->_result['code'] = 600;
			$this->_result['msg'] = trans('book.borrow_action.not_logged');

			return $this->_result;
		}

		//step2 - check the current leadable qty of this member
		$user_leadable_qty = $member->lendable_qty;
		if($user_leadable_qty < 1){
			$this->_result['status'] = false;
			$this->_result['code'] = 601;
			$this->_result['msg'] = trans('book.borrow_action.no_leadable');

			return $this->_result;
		}else if($member->is_active == 0){
			$this->_result['status'] = false;
			$this->_result['code'] = 602;
			$this->_result['msg'] = trans('book.borrow_action.member_forbidden');

			return $this->_result;
		}


		//step3 - check the current borrow&return records of this member
		$user_records = $member->borrow_return_records;
		if($user_records->count() != 0){
			$bbr_cfg = config('books.borrowed_status');
			foreach($user_records as $_urecord){
				if($_urecord->book_isbn == $isbn){
					if($_urecord->status == $bbr_cfg['BeBorrowingNormal']){
						$this->_result['code'] = 603;
						$this->_result['status'] = false;
						$this->_result['msg'] = trans('book.borrow_action.already_borrowing_normal');

						return $this->_result;
					}

					if($_urecord->status == $bbr_cfg['BeBorrowingOverdued']){
						$this->_result['code'] = 604;
						$this->_result['status'] = false;
						$this->_result['msg'] = trans('book.borrow_action.already_borrowing_overdued');

						return $this->_result;
					}
				}
			}
		}

		//step4 - check if the book is borrowable
		$book = $this->br_instance->loadBookByISBN($isbn);
		if($book == null){//there is such a book
			$this->_result['status'] = false;
			$this->_result['code'] = 700;
			$this->_result['msg'] = trans('book.borrow_action.book_not_found');

			return $this->_result;
		}else if($book->stock < 1){// no stock to borrow
			$this->_result['status'] = false;
			$this->_result['code'] = 701;
			$this->_result['msg'] = trans('book.borrow_action.book_no_stock');

			return $this->_result;
		}

		//step5 - borrow it
		$brr = $this->br_instance->borrow($member, $book);
		if($brr == null){//borrow failure
			$this->_result['status'] = false;
			$this->_result['code'] = 800;
			$this->_result['msg'] = trans('book.borrow_action.borrow_failure');

			return $this->_result;
		}
		$brr_recordno = $brr->record_no;

		//Todo -- Normally we need to move the following flow(step6 / step7) to some queue job
		
		//step6 - update some related statistics of this book
		$this->br_instance->updateBookAferBorrowed($book);
		
		//step7 - update the leadable quantity of this member 
		MemberService::getInstance()->updateMemberAfterBorrowed($member);

		$this->_result['status'] = true;
		$this->_result['code'] = 200;
		$this->_result['data'] = $brr_recordno;
		$this->_result['msg'] = trans('book.borrow_action.borrow_success');

		return $this->_result;
	}

	public function returnBook($record_no = ''){

	}

}