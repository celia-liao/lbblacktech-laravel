<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->comment('網站設定表');
            $table->id('setting_id')->comment('設定ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->string('theme_color', 10)->default('#673DE6')->comment('主題顏色');
            $table->string('secondary_color', 10)->default('#FFFFFF')->comment('次要顏色');
            $table->enum('background_type', ['color', 'image', 'video', 'gradient'])->default('color')->comment('背景類型');
            $table->string('background_value', 500)->nullable()->comment('背景值 (顏色代碼/圖片路徑/影片路徑)');
            $table->string('font_family', 100)->default('Noto Sans TC')->comment('字體設定');
            $table->enum('font_size', ['small', 'medium', 'large'])->default('medium')->comment('字體大小');
            $table->string('layout_style', 50)->default('default')->comment('版面風格');
            $table->boolean('auto_play_music')->default(true)->comment('自動播放音樂');
            $table->boolean('show_visitor_count')->default(true)->comment('顯示訪客數');
            $table->boolean('show_timeline')->default(true)->comment('顯示生命軌跡');
            $table->boolean('show_gallery')->default(true)->comment('顯示相片畫廊');
            $table->boolean('show_messages')->default(true)->comment('顯示訪客留言');
            $table->boolean('enable_animations')->default(true)->comment('啟用動畫效果');
            $table->text('custom_css')->nullable()->comment('自定義CSS');
            $table->text('custom_js')->nullable()->comment('自定義JavaScript');
            $table->string('meta_title', 200)->nullable()->comment('SEO標題');
            $table->text('meta_description')->nullable()->comment('SEO描述');
            $table->text('meta_keywords')->nullable()->comment('SEO關鍵字');
            $table->timestamps();
            $table->unique('pet_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
