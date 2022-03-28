<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $table = 'book_category';

    public function books(){
        return $this->hasMany(Book::class, 'category_id');
    }
}
