<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('LenderID');
            $table->unsignedBigInteger('BorrowerID');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['fund', 'repayment', 'withdrawal']);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->text('description')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('LenderID')->references('id')->on('lenders')->onDelete('cascade');
            $table->foreign('BorrowerID')->references('id')->on('borrowers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
