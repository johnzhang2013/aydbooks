<?php
namespace App\Libs;
use GuzzleHttp\Client as HttpClient;

class BookDataGather{
	private static $_instance;
	private $http_worker;
	private $base_path = 'https://chestofbooks.com/';

	private function __clone(){}
	private function __construct(){
		$this->http_worker = new HttpClient(['verify' => false]);
	}

	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function fetch(){
		//step1 - fetch all book categories links
		$categories_links = $this->getBookCateogries();

		//step2 - fetch all books from each book category
		$books = [];
		$total = count($categories_links);
		$i = 1;

        foreach($categories_links as $cate_name => $cate_link){
        	echo 'Start Fetch['.$cate_name.']-->'.$cate_link.'--'.$i.'/'.$total;

        	if(!isset($books[$cate_name])){
        		$books[$cate_name] = [];
        	}

        	$_books = $this->getBooksList($cate_name, $cate_link);
        	$books[$cate_name] = $_books;

        	echo '----total books----'.count($_books).PHP_EOL;
        	$i++;
        	sleep(1);
        }

        return $books;
	}

    private function getBookCateogries(){
        //fetch the top one category from the base page
        $data = $this->__doRequest($this->base_path);
        $book_category_pattern = '/<li\s*class="menu-item"[^>]+>\s*<a\s*href="([^"]+)"\s*>([^\<]+)<\/a>\s*<\/li>/';

        $book_category_links = [];
        if(preg_match_all($book_category_pattern, $data['data'], $category_results)){
        	//$category_results[1] is category link
        	//$category_results[2] is category title
        	foreach($category_results[1] as $_cate_index => $_catelink){
        		if(preg_match('/^https\:\/\//', $_catelink)) continue;//exclude some useless links

        		$book_category_links[$category_results[2][$_cate_index]] = $_catelink;
        	}
        }

        return $book_category_links;
    }

    private function getBooksList($cate_name = '', $cate_link = ''){
    	$book_cate_link = $this->base_path.$cate_link;

    	$data = $this->__doRequest($book_cate_link);
    	if($data['status']){
    		return $this->analyzeBooksList($cate_name, $data['data']);
    	}else{
    		echo 'Failure to fetch books'.PHP_EOL;
    		return null;
    	}
    }

    private function analyzeBooksList($cate_name = '', $html = ''){
    	$books = [];
    	$book_data_pattern = '/<dl\s*class="toc"\>\s*\<dt\>\s*\<a\s*href="([^>]+)"\s*\>\<img[^>]+\>([^<>]+)\<\/a\>\s*\<\/dt\>\s*\<dd\>([^<>]+)\<\/dd\>\s*\<\/dl\>/';
    	if(preg_match_all($book_data_pattern, $html, $book_results)){
    		$link_results = $book_results[1];
    		$title_results = $book_results[2];
    		$intro_results = $book_results[3];

    		foreach($title_results as $_ti => $_title){
    			if($this->checkBookOrCategory($_title)){// This is a book entity
    				$b_t_n = $this->getBookTitleAndAuthor($_title);
    				if($b_t_n){
    					$books[] = [
    						'title' => $b_t_n['title'],
    						'author' => $b_t_n['author'],
    						'intro' => $intro_results[$_ti]
    					];
    				}else{//unknown title pattern
    					//echo something
    					echo 'Failure debug...003'.PHP_EOL;
    				}
    			}else{//This is a book category entity, for simple consider, we ignore it
    				continue;
    			}
    		}
    	}

    	return $books;
    }

    //get the author name and book title
    private function getBookTitleAndAuthor($title = ''){
    	if(empty($title)) return null;

    	$pattern1 = '/.*\s\|\sby.*/';
    	$pattern2 = '/.*\s\|\s.*/';
    	$pattern3 = '/.*\sby\s.*/';


    	if(preg_match($pattern1, $title)){
    		$title_arr = explode(' | by', $title);
    		return [
    			'title' => trim($title_arr[0]),
    			'author' => trim($title_arr[1])
    		];
    	}else if(preg_match($pattern2, $title)){
    		$title_arr = explode(' | ', $title);
    		return [
    			'title' => trim($title_arr[0]),
    			'author' => trim($title_arr[1])
    		];
    	}else if(preg_match($pattern3, $title)){
    		$title_arr = explode(' by ', $title);
    		return [
    			'title' => trim($title_arr[0]),
    			'author' => trim($title_arr[1])
    		];
    	}

    	return null;
    }

    //check if the entity is a real book
    private function checkBookOrCategory($title = ''){
    	$b_title_pattern1 = '/\s\|\sby\s*/';
    	if(preg_match($b_title_pattern1, $title)){// this is an entity of a book
    		return true;
    	}

    	$b_title_pattern2 = '/\s\|\s/';
    	if(preg_match($b_title_pattern2, $title)){// this is an entity of a book
    		return true;
    	}

    	$b_title_pattern3 = '/.*\sby\s.*/';
    	if(preg_match($b_title_pattern3, $title)){// we still take it as an entity of a book though it is strange
    		return true;
    	}

    	$cate_title_pattern = '/.*Books$/';
    	if(preg_match($cate_title_pattern, trim($title))){// this is an entity of a book category
    		return false;
    	}

    	//if none of the above does not match, then we think it is book category
    	return false;
    }

	//handle the http request
	private function __doRequest($url = '', $params = [], $request_type = 'GET'){
		$return = [
			'status' => true,
			'msg' => null,
			'msg_code' => null,
			'data' => null
		];

		try{
			switch($request_type){
				case 'POST':
					$response = $this->http_worker->post($url, $params);
				break;
				case 'PUT':
					$response = $this->http_worker->put($url, $params);
				break;
				default:
					$response = $this->http_worker->get($url, $params);
				break;
			}
			
			$return['data'] = $response->getBody(true)->getContents();
		}catch(\Exception $e){
			$return['status'] = false;
			$return['msg'] = 'Error['.$e->getMessage().']';
			$return['msg_code'] = 'failure_request';
		}

		return $return;
	}
}
