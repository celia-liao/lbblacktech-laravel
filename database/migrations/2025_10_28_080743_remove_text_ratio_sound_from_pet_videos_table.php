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
        Schema::table('pet_videos', function (Blueprint $table) {
            $table->dropColumn(['text', 'ratio', 'sound']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pet_videos', function (Blueprint $table) {
            $table->string('text', 255)->nullable()->comment('影片描述文字 (text)');
            $table->enum('ratio', ['tall', 'long'])->default('tall')->comment('影片比例 (ratio)');
            $table->boolean('sound')->default(false)->comment('是否有聲音 (sound)');
        });
    }
};
