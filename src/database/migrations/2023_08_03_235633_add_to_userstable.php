<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToUserstable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::table('users', function (Blueprint $table) {
        $table->tinyInteger('role')
        ->after('password')
        ->index('index_role');
        $table->foreignId('shop_id')->nullable()->constrained()->cascadeOnDelete();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('userstable', function (Blueprint $table) {
            //
        });
    }
}