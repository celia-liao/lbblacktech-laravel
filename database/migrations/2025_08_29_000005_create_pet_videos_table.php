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
        Schema::create('pet_videos', function (Blueprint $table) {
            $table->comment('寵物影片表');
            $table->id('video_id')->comment('影片ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->string('video_path', 500)->comment('影片路徑 (src)');
            $table->string('text', 255)->nullable()->comment('影片描述文字 (text)');
            $table->enum('ratio', ['tall', 'long'])->default('tall')->comment('影片比例 (ratio)');
            $table->boolean('sound')->default(false)->comment('是否有聲音 (sound)');
            $table->enum('category', ['header', 'bubble', 'corridor'])->comment('影片類別');
            $table->integer('display_order')->default(0)->comment('顯示順序');
            $table->boolean('is_active')->default(true)->comment('是否啟用');
            $table->timestamps();

            $table->index(['pet_id', 'category'], 'idx_pet_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_videos');
    }
};
