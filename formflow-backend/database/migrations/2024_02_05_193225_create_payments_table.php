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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->string('transaction_id');
            $table->integer('amount');
            $table->string('payment_provider');
            $table->dateTime('subscription_start');
            $table->dateTime('subscription_end');

            $table->foreign('user_id')->references('id')->on('users')->onDelete("SET NULL")->onUpdate("SET NULL");
            $table->foreign('package_id')->references('id')->on('packages')->onDelete("SET NULL")->onUpdate("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
