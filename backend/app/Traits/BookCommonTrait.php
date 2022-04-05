<?php
namespace App\Traits;

trait BookCommonTrait{
	private function buildBookOptions($basic_options = []){
        $sys_book_options = [];
        $sys_book_options['authors'] = [];
        $sys_book_options['bookcategories'] = [];

        foreach($basic_options['sys_authors'] as $_author){
            $sys_book_options['authors'][$_author['value']] = $_author['label'];
        }

        foreach($basic_options['sys_bookcategories'] as $_category){
            $sys_book_options['bookcategories'][$_category['value']] = $_category['label'];
        }

        return $sys_book_options;
	}

    private function displayBorrowReturnStatus($brr_status = 0){
        return trans('book.common.brr_status_'.$brr_status);
    }

    private function calcDeadlineDaysLeft($status = 0, $borrow_datetime = 0, $deadline_datetime = 0){
        $bs_cfg = config('books.borrowed_status');

        //no need to display if a book is returned
        if($status == $bs_cfg['BeReturnedNormal'] || $status == $bs_cfg['BeReturnedOverdued']) return '-';

        $borrow_time = strtotime($borrow_datetime);
        $deadline_time = strtotime($deadline_datetime);

        $left_days = ($deadline_time - $borrow_time) / (24 * 3600);

        return $left_days;
    }
}
