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
            $table->string('title');
            $table->string('author');
            $table->string('isbn');
            $table->string('cover_image');
            $table->string('pdf');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('page');
            $table->foreignId('packages_id')->constrained()->onDelete('cascade'); // Added foreign key packages_id
            $table->string('payment_proof')->nullable(); // Added payment_proof column and made it nullable
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
