<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_account_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignId('receiver_account_id')->constrained('accounts')->onDelete('cascade');
            $table->enum('transaction_type', ['credit', 'debit', 'transfer']);
            $table->decimal('amount', 15, 2);
            $table->enum('currency', ['USD', 'GBP', 'EUR']);
            $table->decimal('exchange_rate', 10, 4)->nullable();
            $table->decimal('final_amount', 15, 2);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
