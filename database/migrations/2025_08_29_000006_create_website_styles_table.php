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
        Schema::create('website_styles', function (Blueprint $table) {
            $table->comment('網站樣式設定表');
            $table->id('style_id')->comment('樣式ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->string('loading_color', 20)->default('#f7d6dc')->comment('載入背景顏色 (loading_color)');
            $table->string('cover_name_color', 20)->default('#f4879c')->comment('封面名稱顏色 (coverName_dayNumbers_dayTimeline)');
            $table->string('header_love_color', 50)->default('rgba(244, 135, 156, 0.3)')->comment('封面愛心顏色 (header_love)');
            $table->string('header_footprint_color', 20)->default('#ffc5ea')->comment('封面腳印顏色 (header_footprint)');
            $table->string('day_text_color', 20)->default('rgb(117, 24, 58)')->comment('生命軌跡文字顏色 (dayText_dayAge)');
            $table->string('title_color', 20)->default('rgb(198, 150, 166)')->comment('標題顏色 (title_color)');
            $table->string('handshake_button_color', 20)->default('#cc96ff')->comment('握手按鈕顏色 (handshake_button)');
            $table->string('videos_button_color', 20)->default('#ff91bf')->comment('影片按鈕顏色 (videos_button)');
            $table->string('bubble_ball_color', 20)->default('#ffd2d5')->comment('泡泡顏色 (bubble_ball)');
            $table->text('bubble_background')->comment('泡泡背景漸層 (bubble_background)');
            $table->string('footprint_color', 20)->default('#f7cfda')->comment('腳印顏色 (footprint_all)');
            $table->string('footer_background_color', 20)->default('rgb(255, 220, 227)')->comment('頁尾背景顏色 (footer_background)');
            $table->string('function_color', 20)->default('#C696A6')->comment('功能列顏色 (function_color)');
            $table->string('function_background_color', 50)->default('rgba(255, 220, 227, 0.9)')->comment('功能列背景顏色 (function_background)');
            $table->timestamps();
            
            $table->unique('pet_id', 'uk_pet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_styles');
    }
};
