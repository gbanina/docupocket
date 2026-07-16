<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('isprave', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('category');
            $table->string('document_number')->nullable();
            $table->string('issuer')->nullable();
            $table->date('issued_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->boolean('reminder_enabled')->default(true);
            $table->unsignedSmallInteger('reminder_days')->default(90);
            $table->text('note')->nullable();
            $table->string('front_image_path')->nullable();
            $table->string('back_image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('isprave');
    }
};
