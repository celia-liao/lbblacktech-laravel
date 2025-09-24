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
        Schema::create('life_slides', function (Blueprint $table) {
            $table->comment('輪播圖');
            $table->id('life_slide_id')->comment('輪播圖ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->string('life_slide_image', 500)->nullable()->comment('圖片路徑');
            $table->string('life_slide_video', 500)->nullable()->comment('影片路徑');
            $table->boolean('is_active')->default(true)->comment('是否啟用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('life_slides');
    }
};
