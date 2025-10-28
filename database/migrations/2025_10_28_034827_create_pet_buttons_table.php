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
        Schema::create('pet_buttons', function (Blueprint $table) {
            $table->comment('寵物按鈕表');
            $table->id('button_id')->comment('按鈕ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->enum('button_type', ['image', 'video'])->comment('按鈕類型：image=圖片, video=影片');
            $table->string('button_text', 100)->comment('按鈕顯示文字');
            $table->string('media_path', 500)->nullable()->comment('媒體檔案路徑（圖片或影片）');
            $table->enum('ratio', ['tall', 'long'])->nullable()->comment('影片比例（僅影片類型使用）');
            $table->boolean('sound')->default(false)->comment('是否有聲音（僅影片類型使用）');
            $table->boolean('is_active')->default(true)->comment('是否啟用');
            $table->timestamps();

            $table->index(['pet_id', 'button_type'], 'idx_pet_button_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_buttons');
    }
};
