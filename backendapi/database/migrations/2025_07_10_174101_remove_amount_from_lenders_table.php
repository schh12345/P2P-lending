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
            $table->dropColumn('amount');
        });
    }

    public function down()
    {
        Schema::table('lenders', function (Blueprint $table) {
            $table->double('amount')->default(0); // or restore as originally defined
        });
    }
};
