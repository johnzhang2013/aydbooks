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
}
