<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBookModuleAddDeadline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrow_return_record', function (Blueprint $table) {
            $table->dateTime('deadline_datetime')->after('overdued_days')->comment('The deadline date of a book should be returned');
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
            $table->dropColumn('deadline_date');
        });
    }
}
