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
        Schema::create('account_traces', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu');
            $table->string('invoice', 60)->index();
            $table->string('description', 160);
            $table->string('debt_code', 60);
            $table->string('cred_code', 60);
            $table->integer('jumlah');
            $table->integer('status')->default(1);
            $table->string('rcv_pay', 30)->nullable();
            $table->integer('pay_stats')->nullable();
            $table->integer('pay_nth')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('warehouse_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_traces');
    }
};
