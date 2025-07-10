<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lenders', function (Blueprint $table) {
            $table->dropColumn('credit_score'); // or whatever change you want
        });
    }

    public function down()
    {
        Schema::table('lenders', function (Blueprint $table) {
            $table->integer('credit_score')->default(100); // rollback addition
        });
    }
};
