<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';

    /**
    * automatic generate the book isbn
    */
    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->isbn = uniqid();
        });
    }

    //return all borrowing normal records of this book
    public function normalBorrowings(){
        $brr_cfg = config('books.borrowed_status');

        return $this->belonsToMany(BorrowReturnRecord::class)->where('status', $brr_cfg['BeBorrowingNormal']);
    }

    //return all borrowing overdued records of this book
    public function overduedBorrowings(){
        $brr_cfg = config('books.borrowed_status');

        return $this->belonsToMany(BorrowReturnRecord::class)->where('status', $brr_cfg['BeBorrowingOverdued']);
    }

    //return all returned normal records of this book
    public function normalReturned(){
        $brr_cfg = config('books.borrowed_status');

        return $this->belonsToMany(BorrowReturnRecord::class)->where('status', $brr_cfg['BeReturnedNormal']);
    }

    //return all returned overdued records of this book
    public function overduedReturned(){
        $brr_cfg = config('books.borrowed_status');

        return $this->belonsToMany(BorrowReturnRecord::class)->where('status', $brr_cfg['BeReturnedOverdued']);
    }

    //Calc the sum of all books stock
    public static function allStockSum(){
        return self::sum('stock');
    }
}
