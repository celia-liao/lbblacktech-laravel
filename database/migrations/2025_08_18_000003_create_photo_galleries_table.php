<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_galleries', function (Blueprint $table) {
            $table->comment('相片畫廊表');
            $table->id('photo_id')->comment('照片ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->string('gallery_name', 100)->nullable()->comment('相簿名稱');
            $table->string('photo_path', 500)->comment('照片路徑');
            $table->string('photo_title', 200)->nullable()->comment('照片標題');
            $table->string('photo_caption', 500)->nullable()->comment('照片說明');
            $table->enum('photo_category', ['daily', 'special', 'medical', 'portrait', 'event', 'other'])->default('daily')->comment('照片分類');
            $table->integer('file_size')->nullable()->comment('檔案大小 (bytes)');
            $table->string('file_type', 20)->nullable()->comment('檔案類型 (jpg/png/gif)');
            $table->integer('width')->nullable()->comment('圖片寬度');
            $table->integer('height')->nullable()->comment('圖片高度');
            $table->timestamp('upload_date')->useCurrent()->comment('上傳日期');
            $table->integer('display_order')->default(0)->comment('顯示順序');
            $table->boolean('is_visible')->default(true)->comment('是否顯示');
            $table->integer('view_count')->default(0)->comment('瀏覽次數');
            $table->timestamps();
            $table->index(['pet_id', 'photo_category']);
            $table->index('display_order');
            $table->index('is_visible');
            $table->index('upload_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_galleries');
    }
};
