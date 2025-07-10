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
        schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('borrower_id')->constrained()->onDelete('cascade');
            $table->foreignId('lender_id')->constrained()->onDelete('cascade');
            $table->double('amount');
            $table->enum('status', ['pending', 'active', 'completed'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('transactions');
    }
};
