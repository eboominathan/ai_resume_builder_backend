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
        Schema::create('customer_details', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('customerId')->nullable();
            $table->string('title')->nullable();
            $table->string('door_no')->nullable();
            $table->integer('street')->nullable();
            $table->string('landmark')->nullable();
            $table->integer('area')->nullable();
            $table->integer('village')->nullable();
            $table->string('district')->nullable();
            $table->string('pincode')->nullable();
            $table->string('state')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('theme_color')->default('#ff6666');
            $table->text('summary')->nullable();
            $table->timestamps();            
            $table->softDeletes();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_details');
    }
};
