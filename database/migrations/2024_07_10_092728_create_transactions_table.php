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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('square_payment_id')->unique();
            $table->integer('amount');
            $table->string('currency');
            $table->string('status');
            $table->string('card_brand');
            $table->string('card_last_four');
            $table->tinyInteger('card_exp_month');
            $table->smallInteger('card_exp_year');
            $table->dateTime('created_at')->index();
            $table->dateTime('updated_at')->index();
            $table->string('receipt_url');
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
