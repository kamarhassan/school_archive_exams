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
        Schema::create('competitions', function (Blueprint $table) {
          $table->id();
    $table->string('teacher_name');
    $table->enum('shift', ['صباحي', 'مسائي']);
    $table->string('grade');
    $table->string('subject');
    $table->string('competition_file');
    $table->string('answer_key_file');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
