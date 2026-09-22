<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->string('code', 10)->unique();
        $table->string('name');
        $table->unsignedInteger('credit_hours')->default(3);
        $table->foreignId('lecturer_id')->nullable()->constrained('lecturers')->nullOnDelete();
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};