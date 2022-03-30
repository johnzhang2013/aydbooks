<?php

use Illuminate\Database\Seeder;


use App\Service\BookStatisticService;

class BookStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $bss_instance = null;

    public function run()
    {
        //$this->bss_instance = BookStatisticService::getInstance();

        //$this->getStocksAndBorrowings();

        //$this->getTopBorrowedCountBooks();
        //$this->getTopOverduedCountBooks();
        //$this->getTopBorrowedCountBookCategories();
        //$this->getTopOverduedCountBookCategories();
    }

    private function getStocksAndBorrowings(){
        $data = $this->bss_instance->getStocksAndBorrowings();
        print_r($data);
    }

    private function getTopBorrowedCountBooks(){
        $n = 2;

        $data = $this->bss_instance->getTopBorrowedCountBooks($n);        
        print_r($data);
    }

    private function getTopOverduedCountBooks(){
        $n = 10;

        $data = $this->bss_instance->getTopOverduedCountBooks($n);        
        print_r($data);
    }

    private function getTopBorrowedCountBookCategories(){
        $n = 2;

        $data = $this->bss_instance->getTopBorrowedCountBookCategories($n);        
        print_r($data);
    }

    private function getTopOverduedCountBookCategories(){
        $n = 5;

        $data = $this->bss_instance->getTopOverduedCountBookCategories($n);        
        print_r($data);
    }
}
