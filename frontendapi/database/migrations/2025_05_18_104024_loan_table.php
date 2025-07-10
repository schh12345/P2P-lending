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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('BorrowerID');
            $table->foreign('BorrowerID')->references('id')->on('borrowers')->onDelete('cascade');

            $table->unsignedBigInteger('request_id')->nullable();
            $table->foreign('request_id')->references('request_id')->on('loan_requests')->onDelete('cascade');
            $table->integer('request_duration')->nullable();
            $table->text('request_reason');
            $table->double('request_amount');
            $table->float('interest_rate')->nullable();
            $table->double('total', 10,2);
            $table->enum('status', ['Pending', 'Active', 'Completed', 'Funded'])->default('Pending')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
        Schema::create('loan_after_approves', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('borrower_id')->constrained()->onDelete('cascade');
            //$table->foreignId('lender_id')->constrained()->onDelete('cascade');
            $table->double('amount');
            $table->integer('duration');
            $table->text('reason');
            $table->float('interest_rate');
            $table->text ('employment_status');
            $table->float('income');
            $table->timestamp('start_date');
            $table->timestamp('payment_date');
            $table->integer('lateDay')->nullable();
            $table->integer('last_penalized_day')->nullable();
            $table->double('total', 10, 2);
            $table->enum('status', ['Pending', 'Active', 'Completed', 'Late'])->default('Active')->nullable();
            // $table->string('identity_path');
            // $table->string('employment_path');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps(); // includes created_at and updated_at
            $table->unsignedBigInteger('request_id')->nullable();

            $table->foreign('request_id')->references('request_id')->on('loan_requests')->onDelete('cascade');

            $table->unsignedBigInteger('BorrowerID');
            $table->unsignedBigInteger('LenderID');

            $table->foreign('BorrowerID')->references('id')->on('borrowers')->onDelete('cascade');
            $table->foreign('LenderID')->references('id')->on('lenders')->onDelete('cascade');
        });


    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
