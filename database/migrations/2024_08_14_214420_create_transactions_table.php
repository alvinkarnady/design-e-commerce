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
            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_post');
            $table->unsignedBigInteger('id_category');
            $table->timestamps();

            $table->foreign('id_order')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_user')->references('id')->on('data_users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_post')->references('id')->on('data_posts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_category')->references('id')->on('data_categories')->onDelete('cascade')->onUpdate('cascade');
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
