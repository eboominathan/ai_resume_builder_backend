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

            // Foreign keys with cascading delete
            $table->foreignId('category_id')
                ->constrained('categories') // References 'id' in 'categories' table
                ->onDelete('cascade');

            $table->foreignId('sub_category_id')
                ->constrained('sub_categories') // References 'id' in 'sub_categories' table
                ->onDelete('cascade');

            // Service details
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 2)->nullable()->comment('Total amount for the service');

            // Enum for payment status
            $table->enum('payment_status', ['paid', 'pending', 'partially paid', 'Not Paid'])
                ->default('Not Paid')
                ->comment('1 - paid,2- pending,3- partially paid,4-Not Paid');

            // Additional comments
            $table->string('comments')->nullable();

            // Timestamps and soft deletes
            $table->softDeletes();
            $table->timestamps();
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
