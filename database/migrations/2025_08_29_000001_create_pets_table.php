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
        Schema::create('pets', function (Blueprint $table) {
            $table->comment('寵物基本資料表');
            $table->id('pet_id')->comment('寵物ID');
            $table->string('pet_name', 100)->comment('寵物名稱');
            $table->string('website_slug', 100)->unique()->comment('網站識別碼');
            $table->text('slogan')->nullable()->comment('給毛孩的一句話 (main-img-area-slogan h1)');
            $table->boolean('is_active')->default(true)->comment('是否啟用');
            $table->timestamps();
            
            $table->index('is_active', 'idx_is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
