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
        Schema::create('family_details', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender',['male','female','other'])->default('male');
            $table->string('relationship')->nullable();
            $table->string('occupation')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('theme_color')->default('#ff6666');
            $table->text('summary')->nullable();
            $table->foreignId('customer_id')->constrained('customer_details');
            $table->foreignId('user_id')->constrained('users');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_details');
    }
};
