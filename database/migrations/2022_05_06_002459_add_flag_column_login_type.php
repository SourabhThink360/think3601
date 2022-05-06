<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagColumnLoginType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('users', function ($table) {
            $table->string('flag')->nullable()->after('remember_token')->default('0');
            $table->string('login_type')->nullable()->after('remember_token')->default('normal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function($table) {
            $table->dropColumn('flag');
            $table->dropColumn('login_type');

        });
    }
}
