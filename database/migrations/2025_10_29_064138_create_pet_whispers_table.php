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
        Schema::create('pet_whispers', function (Blueprint $table) {
            $table->comment('寵物小語表');
            $table->id('whisper_id')->comment('小語ID');
            $table->unsignedBigInteger('pet_id')->nullable()->comment('寵物ID (null為預設小語)');
            $table->text('content')->comment('小語內容');
            $table->timestamps();
            
            // 外鍵約束
            $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('cascade');
            
            // 索引
            $table->index('pet_id', 'idx_pet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_whispers');
    }
};
