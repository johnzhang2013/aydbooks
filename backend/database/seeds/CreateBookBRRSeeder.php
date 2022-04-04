<?php

use Illuminate\Database\Seeder;
use App\Service\BookService;
use App\Repositories\Member as MemberRepository;
use App\Repositories\Book as BookRepository;

class CreateBookBRRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $n = 1000;

        $this->borrowBooks($n);
    }

    private function borrowBooks($number = 0){
        $borrow_success = 0;
        $borrow_failure = 0;
        for($i = 0; $i < $number; $i++){
            $res = $this->borrowOneBook();

            if($res['status'] == true && $res['code'] == 200){
                $borrow_success++;
            }else{
                $borrow_failure++;
            }
        }

        echo '###################################This seeder runs results#################################'.PHP_EOL;
        echo 'Borrow Book Seeder Total['.$number.'] Success['.$borrow_success.'] Failure['.$borrow_failure.']'.PHP_EOL;
    }

    private function borrowOneBook(){
        //step1 - fetch one member randomly
        $member = MemberRepository::getInstance()->getOneRandomMember();

        //step2 - fetch a book randomly
        $book =  BookRepository::getInstance()->loadOneRandomBook();

        //step3 - borrow it and print the borrow result
        $borrow_result = BookService::getInstance()->borrowBook($member->id, $book->isbn);

        $borrow_log = 'Member['.$member->name.'] borrow book['.$book->title.'] - ';
        if($borrow_result['status'] && $borrow_result['code'] == 200){
            $borrow_log .= 'Success'.PHP_EOL;
        }else{
            $borrow_log .= 'Failure ['.$borrow_result['code'].']['.$borrow_result['msg'].']'.PHP_EOL;
        }
        echo $borrow_log;

        return $borrow_result;
    }


    private function returnBooks($number = 0){
        $return_success = 0;
        $return_failure = 0;
        for($i = 0; $i < $number; $i++){
            $res = $this->returnOneBook();

            if($res['status'] == true){
                $return_success++;
            }else{
                $return_failure++;
            }
        }

        echo '###########This seeder runs results#########'.PHP_EOL;
        echo 'Return Book Seeder Total['.$number.'] Success['.$borrow_success.'] Failure['.$borrow_failure.']'.PHP_EOL;
    }

    private function returnOneBook(){

    }
}
