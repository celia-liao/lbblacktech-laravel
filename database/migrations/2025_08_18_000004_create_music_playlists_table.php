<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('music_playlists', function (Blueprint $table) {
            $table->comment('音樂播放清單表');
            $table->id('music_id')->comment('音樂ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->string('song_title', 200)->comment('歌曲標題 (如：Beloved Dream)');
            $table->string('song_path', 500)->comment('音樂檔案路徑');
            $table->string('artist', 100)->nullable()->comment('藝術家/作者');
            $table->string('album', 100)->nullable()->comment('專輯名稱');
            $table->time('duration')->nullable()->comment('歌曲長度');
            $table->integer('file_size')->nullable()->comment('檔案大小 (bytes)');
            $table->string('file_type', 10)->nullable()->comment('檔案格式 (mp3/m4a/wav)');
            $table->decimal('volume', 3, 2)->default(0.60)->comment('預設音量 (0.00-1.00)');
            $table->boolean('auto_play')->default(true)->comment('是否自動播放');
            $table->boolean('loop_mode')->default(true)->comment('是否循環播放');
            $table->integer('play_order')->default(0)->comment('播放順序');
            $table->integer('play_count')->default(0)->comment('播放次數');
            $table->boolean('is_active')->default(true)->comment('是否啟用');
            $table->timestamps();
            $table->index(['pet_id', 'play_order']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('music_playlists');
    }
};
