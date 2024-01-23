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
        Schema::create('receivables', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_issued');
            $table->dateTime('due_date');
            $table->string('invoice', 60)->index();
            $table->string('description', 160);
            $table->integer('bill_amount');
            $table->integer('payment_amount');
            $table->integer('payment_status');
            $table->integer('payment_nth');
            $table->foreignId('contact_id');
            $table->string('account_code', 10)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receivables');
    }
};
