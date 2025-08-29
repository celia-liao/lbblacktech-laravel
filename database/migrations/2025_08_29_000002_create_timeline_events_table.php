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
        Schema::create('timeline_events', function (Blueprint $table) {
            $table->comment('生命軌跡事件表');
            $table->id('event_id')->comment('事件ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->string('age', 50)->comment('事件發生時的年齡 (age)');
            $table->string('event_title', 500)->comment('事件標題 (title)');
            $table->text('event_description')->nullable()->comment('事件詳細描述 (text)');
            $table->string('background', 500)->nullable()->comment('事件背景圖片路徑 (background)');
            $table->string('event_photo', 500)->nullable()->comment('事件相關照片路徑 (image)');
            $table->string('original_image', 500)->nullable()->comment('事件原始圖片路徑 (originalImage)');
            $table->boolean('is_ending')->default(false)->comment('是否為結尾事件 (ending)');
            $table->integer('display_order')->default(0)->comment('顯示順序');
            $table->boolean('is_visible')->default(true)->comment('是否顯示');
            $table->timestamps();
            
            $table->index('pet_id', 'idx_pet_id');
            $table->index('display_order', 'idx_display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_events');
    }
};
