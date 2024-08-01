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
        Schema::create('experiences', function (Blueprint $table) {     
                $table->id();
                $table->foreignId('resume_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->string('company_name');
                $table->string('city');
                $table->string('state');
                $table->string('start_date');
                $table->string('end_date')->nullable();
                $table->boolean('currently_working')->default(false);
                $table->text('work_summary');
                $table->timestamps();   
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
