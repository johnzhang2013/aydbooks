<?php
use Illuminate\Database\Seeder;
use App\Libs\BookDataGather;

use App\Service\BookService;
use App\Service\AuthorService;

class BookDataGatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $bs_instance = null;
    private $as_instance = null;

    public function run()
    {
        //$this->bs_instance = BookService::getInstance();
        //$this->as_instance = AuthorService::getInstance();

        //$this->doGather();
    }

    private function doGather(){
        $bdg = BookDataGather::getInstance();

        $books = $bdg->fetch();
        $books_total = count($books);
        if($books_total == 0){
            echo 'Whoops..you are not lucky at the moment'.PHP_EOL;
            return;
        }else{
            echo 'Congrats, You fetched some books, move futher!'.PHP_EOL;
        }

        foreach($books as $_cate_name => $_books){
            $this->saveBooks($_cate_name, $_books);
        }
    }

    private function saveBooks($cate_name, $books){
        //step1 - get the book category id
        $_book_cate_id = $this->handleBookCategory($cate_name);

        foreach($books as $_book){
            //step2 - get the author id
            $_author_name = $_book['author'];
            $_book_author_id = $this->handleAuthor($_author_name);

            //step3 - build the book data
            $book_data = [
                'category_id' => $_book_cate_id,
                'author_id' => $_book_author_id,
                'stock' => rand(1, 20),
                'is_active' => 1,
                'borrowed_count' => rand(1, 100),
                'title' => $_book['title'],
                'brief_intro' => $_book['intro'],
                'onshelf_datetime' => date('Y-m-d H:i:s')
            ];

            //step4 - save the book
            $book_entity = $this->bs_instance->createBook($book_data);
            if($book_entity == null){
                echo 'Failure to create book['.$_book['title'].']'.PHP_EOL;
            }else{
                echo 'Perfect to create book['.$_book['title'].']'.PHP_EOL;
            }    
        }
    }

    private function handleBookCategory($cate_name = ''){
        //look up it
        $cate_name = trim($cate_name);
        $bc = $this->bs_instance->loadBookCategory($cate_name);
        if($bc == null){
            $bc = $this->bs_instance->createBookCategory(['name' => $cate_name]);
        }

        return $bc->id;
    }

    private function handleAuthor($author_name = ''){
        //look up it
        $author_name = $this->specialHandleAuthorName($author_name);

        $author = $this->as_instance->loadAuthor($author_name);
        if($author == null){
            $author = $this->as_instance->createAuthor(['name' => $author_name]);
        }

        return $author->id;
    }

    private function specialHandleAuthorName($author_name = ''){
        $author_name = trim($author_name);

        return preg_replace('/^By\s*/', '', $author_name);
    }
}
