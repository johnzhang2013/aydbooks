<?php
namespace App\Service;

use App\Repositories\Author as AuthorRepository;
use App\Repositories\Book as BookRepository;

use Illuminate\Database\Eloquent\Collection as BSSEloquentCollection;

class BookStatisticService{
	private static $_instance;
	private $_result = null;
	private $ar_instance = null;
	private $br_instance = null;

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
		$this->br_instance = BookRepository::getInstance();
	}

	//Singleton use
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	//Get stock/borrowed ratio of all books
	public function getStocksAndBorrowings(){
		//The sum of all books stock 
		$all_stocks = $this->br_instance->allStockSum();

		//all borrowing(both normal and overdued included) count
		$all_borrowings = $this->br_instance->allBorrowingCount();

		return [
			'all_stocks' => $all_stocks,
			'all_borrowings' => $all_borrowings
		];
	}
	
	//Get top n borrowed count books
	public function getTopBorrowedCountBooks($n = 10){
		//For better performance, I should save and fetch it from some Cache middleware(Redis/Cache)
		//$cacke_key = 'top_borrowed_books_'.$n

		$top_books = $this->br_instance->listTopBorrowedCountBooks($n);
		return $this->buildTopCountBooksData($top_books, 'borrowed');
	}

	//Get top n overdued count books
	public function getTopOverduedCountBooks($n = 10){
		//For better performance, I should save and fetch it from some Cache middleware(Redis/Cache)
		//$cacke_key = 'top_overdued_books_'.$n

		$top_books = $this->br_instance->listTopOverduedCountBooks($n);

		return $this->buildTopCountBooksData($top_books, 'overdued');
	}

	//Get top n borrowed count book categories
	public function getTopBorrowedCountBookCategories($n = 10){
		//For better performance, I should save and fetch it from some Cache middleware(Redis/Cache)
		//$cacke_key = 'top_borrowed_bookcates_'.$n
		
		$top_bookcates = $this->br_instance->listTopBorrowedCountBookCategories($n);
		return $this->buildTopCountBookCategoriesData($top_bookcates, 'borrowed');
	}

	//Get top n overdued count book categories
	public function getTopOverduedCountBookCategories($n = 10){
		//For better performance, I should save and fetch it from some Cache middleware(Redis/Cache)
		//$cacke_key = 'top_overdued_bookcates_'.$n

		$top_bookcates = $this->br_instance->listTopOverduedCountBookCategories($n);
		return $this->buildTopCountBookCategoriesData($top_bookcates, 'overdued');;
	}

	/**
	 *Buid an array data format for top count business
	 *@param BSSEloquentCollection $top_books
	 *@param string $count_type
	 *@return array
	 * 
	 */
	private function buildTopCountBooksData(BSSEloquentCollection $top_books = null, $count_type = 'borrowed'){
		$top_books_data = [];
		foreach($top_books as $_tb){
			$_tbd = [];
			$_tbd['title'] = $_tb->title;
			$_tbd['count'] = ($count_type == 'borrowed') ? $_tb->borrowed_count : $_tb->overdued_count;

			$top_books_data[] = $_tbd;
		}

		return $top_books_data;
	}

	/**
	 *Buid an array data format for top count business
	 *@param BSSEloquentCollection $top_bookcates
	 *@param string $count_type
	 *@return array
	 * 
	 */
	private function buildTopCountBookCategoriesData(BSSEloquentCollection $top_bookcates = null, $count_type = 'borrowed'){
		$_top_cates = [];

		$top_bookcate_data = [];
		foreach($top_bookcates as $_tbc){
			$_tbcd = [];

			if(!isset($_top_cates[$_tbc->category_id])){
				$_cate = $this->br_instance->loadBookCategory($_tbc->category_id);
				if($_cate == null) continue;

				$_top_cates[$_tbc->category_id] = $_cate->name;
			}

			$_tbcd['title'] = $_top_cates[$_tbc->category_id];
			$_tbcd['count'] = ($count_type == 'borrowed') ? $_tbc->cate_borrowed_count : $_tbc->cate_overdued_count;

			$top_bookcate_data[] = $_tbcd;
		}

		return $top_bookcate_data;
	}
}