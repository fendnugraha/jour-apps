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
        Schema::create('payables', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu');
            $table->string('invoice', 60)->index();
            $table->string('description', 160);
            $table->integer('bill_amount');
            $table->integer('pay_amount');
            $table->integer('pay_stats');
            $table->integer('pay_nth');
            $table->foreignId('contact_id');
            $table->foreignId('account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payables');
    }
};
