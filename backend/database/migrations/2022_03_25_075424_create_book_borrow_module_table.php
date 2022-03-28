<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookBorrowModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author', function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name', 128)->default(NULL)->nullable()->comment('The full name of author');

            $table->timestamps();
        });

        Schema::create('book', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('category_id', false, true)->default(0)->index()->comment('The categoryid of book');
            $table->integer('author_id', false, true)->default(0)->index()->comment('The authorid of book');            
            $table->integer('stock', false, true)->default(0)->comment('The stock quantity of book');
            $table->boolean('is_active')->default(0)->index()->comment('Is this book borrowable');

            $table->string('title', 128)->default(NULL)->nullable()->comment('The title of book');
            $table->text('brief_intro')->default(NULL)->nullable()->comment('The brief introduction of book');

            $table->timestamps();
        });

        Schema::create('book_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('name', 128)->default(NULL)->nullable()->comment('The category name');

            $table->timestamps();
        });

        Schema::create('borrow_return_record', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_id', false, true)->default(0)->index()->comment('The borrower');
            $table->integer('book_id', false, true)->default(0)->index()->comment('The book id');

            //Just a personal opinion, it is better to solidify the book title in this table
            $table->string('book_title', 128)->default(NULL)->nullable()->comment('The book title');
            $table->tinyInteger('status')->default(0)->comment('The record status of a book[0 Returned / 1 Borrowed out / 2 Overdue]');

            $table->dateTime('borrowed_datetime')->default(NULL)->nullable()->comment('The accurate date time of a book borrowed out');
            $table->dateTime('returned_datetime')->default(NULL)->nullable()->comment('The accurate date time of a book returned');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('author');
        Schema::dropIfExists('book');
        Schema::dropIfExists('book_category');
        Schema::dropIfExists('borrow_return_record');
    }
}
