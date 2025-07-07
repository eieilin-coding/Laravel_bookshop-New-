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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id');
            $table->integer('category_id');
            $table->string('title');
            $table->string('publisher');
            $table->string('published_date');
            $table->text('description');
            $table->string('photo');
            $table->string('file');
            $table->integer('temp_delete');
            $table->integer('download_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
