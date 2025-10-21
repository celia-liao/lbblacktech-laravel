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
        Schema::table('life_slides', function (Blueprint $table) {
            // 重命名 life_slide_video 为 life_slide_media
            $table->renameColumn('life_slide_video', 'life_slide_media');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('life_slides', function (Blueprint $table) {
            // 重命名回原来的名称
            $table->renameColumn('life_slide_media', 'life_slide_video');
        });
    }
};
