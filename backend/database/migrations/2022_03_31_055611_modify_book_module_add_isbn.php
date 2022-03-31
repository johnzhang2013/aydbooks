<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBookModuleAddIsbn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrow_return_record', function (Blueprint $table) {
            $table->string('book_isbn', 16)->index()->after('book_id')->comment('The book isbn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrow_return_record', function (Blueprint $table) {
            $table->dropColumn('book_isbn');
        });
    }
}
