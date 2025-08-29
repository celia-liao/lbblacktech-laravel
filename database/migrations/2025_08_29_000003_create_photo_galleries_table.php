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
        Schema::create('photo_galleries', function (Blueprint $table) {
            $table->comment('照片畫廊表');
            $table->id('photo_id')->comment('照片ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->string('photo_path', 500)->comment('照片路徑');
            $table->enum('photo_category', ['header', 'bubble_small', 'bubble_large', 'corridor'])->comment('照片類別');
            $table->string('original_image', 500)->nullable()->comment('原始圖片路徑');
            $table->integer('display_order')->default(0)->comment('顯示順序');
            $table->boolean('is_active')->default(true)->comment('是否啟用');
            $table->timestamps();
            
            $table->index(['pet_id', 'photo_category'], 'idx_pet_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_galleries');
    }
};
