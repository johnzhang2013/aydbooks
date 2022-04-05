<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Faker\Provider\Uuid as Uuid;

class BorrowReturnRecord extends Model
{
    protected $table = 'borrow_return_record';

    /**
    * automatic generate the book isbn
    */
    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $uuid_str = (string)Uuid::uuid();
            $recordno_str = md5($uuid_str);
            $recordno_str = strtoupper($recordno_str);

            $model->record_no = $recordno_str;

        });
    }

    public function member(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
