<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_analytics', function (Blueprint $table) {
            $table->comment('網站分析統計表');
            $table->id('analytics_id')->comment('統計ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->date('visit_date')->comment('訪問日期');
            $table->integer('visitor_count')->default(0)->comment('訪客數量');
            $table->integer('page_views')->default(0)->comment('頁面瀏覽量');
            $table->integer('unique_visitors')->default(0)->comment('獨特訪客數');
            $table->decimal('bounce_rate', 5, 2)->default(0.00)->comment('跳出率 (%)');
            $table->time('avg_session_duration')->nullable()->comment('平均停留時間');
            $table->integer('mobile_visitors')->default(0)->comment('手機訪客數');
            $table->integer('desktop_visitors')->default(0)->comment('桌機訪客數');
            $table->integer('tablet_visitors')->default(0)->comment('平板訪客數');
            $table->json('referrer_data')->nullable()->comment('來源網站統計 (JSON格式)');
            $table->json('country_data')->nullable()->comment('國家統計 (JSON格式)');
            $table->json('browser_data')->nullable()->comment('瀏覽器統計 (JSON格式)');
            $table->timestamps();
            $table->unique(['pet_id', 'visit_date']);
            $table->index('visit_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_analytics');
    }
};
