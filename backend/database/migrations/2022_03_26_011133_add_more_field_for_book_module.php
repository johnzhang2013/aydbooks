<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldForBookModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book', function (Blueprint $table) {
            $table->string('isbn', 16)->unique()->after('id')->comment('The unique isbn of each book');
            $table->integer('borrowed_count', false, true)->default(0)->nullable()->after('brief_intro')->comment('The total borrowed times of each book');
            $table->integer('overdued_count', false, true)->default(0)->nullable()->after('borrowed_count')->comment('The total overdued times of each book');
            $table->dateTime('onshelf_datetime')->default(NULL)->nullable()->after('overdued_count')->comment('The accurate date time of each book set to be on shelf');
        });

        Schema::table('borrow_return_record', function (Blueprint $table) {
            $table->string('record_no', 32)->unique()->after('id')->comment('The unique record no of each book borrowing record');
            $table->integer('overdued_days', false, true)->default(0)->nullable()->after('status')->comment('The overdued days of each book borrowing records');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book', function (Blueprint $table) {
            $table->dropColumn('isbn');
            $table->dropColumn('borrowed_count');
            $table->dropColumn('overdued_count');
            $table->dropColumn('onshelf_datetime');
        });

        Schema::table('borrow_return_record', function (Blueprint $table) {
            $table->dropColumn('record_no');
            $table->dropColumn('overdued_days');
        });
    }
}
