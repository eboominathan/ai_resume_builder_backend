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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('categories') // References 'id' in 'categories' table
                ->onDelete('cascade');

            $table->foreignId('sub_category_id')
                ->constrained('sub_categories') // References 'id' in 'sub_categories' table
                ->onDelete('cascade');
            $table->string('acknowlegement_no')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('location')->nullable();
            $table->string('comments')->nullable();
            $table->string('follower')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
