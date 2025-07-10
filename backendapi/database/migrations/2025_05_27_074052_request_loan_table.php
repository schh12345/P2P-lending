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
        Schema::create('loanRequest', function (Blueprint $table) {
            $table->id('request_id');

            // Foreign Keys
            $table->unsignedBigInteger('BorrowerID');
            $table->foreign('BorrowerID')->references('id')->on('borrowers')->onDelete('cascade');

            $table->double('request_amount');
            $table->integer('request_duration')->nullable(); // Duration in months (for example)
            $table->text('request_reason');
            $table->float('interest_rate')->nullable();
            $table->decimal('total', 10, 2)->nullable(); // Total repayable amount (amount + interest)

            // Status Lifecycle
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Active', 'Completed'])->default('Pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();


            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loanRequest');
    }
};
