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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->comment('網站設定表');
            $table->id('setting_id')->comment('設定ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->integer('target_number')->comment('最後天數 (targetNumber)');
            $table->integer('duration')->default(4000)->comment('動畫時間(毫秒) (duration)');
            $table->integer('corridor_random_image_count')->default(12)->comment('記憶迴廊隨機張數 (pictureNum)');
            $table->string('creation_date', 20)->comment('製作日期 (startDateStr)');
            $table->timestamps();
            
            $table->unique('pet_id', 'uk_pet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
