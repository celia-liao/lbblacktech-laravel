<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timeline_events', function (Blueprint $table) {
            $table->comment('生命軌跡事件表');
            $table->id('event_id')->comment('事件ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->date('event_date')->comment('事件日期');
            $table->integer('age_years')->default(0)->comment('事件發生時的歲數');
            $table->integer('age_months')->default(0)->comment('事件發生時的月份');
            $table->integer('age_days')->default(0)->comment('事件發生時的天數');
            $table->string('event_title', 200)->comment('事件標題');
            $table->text('event_description')->nullable()->comment('事件詳細描述');
            $table->string('event_photo', 500)->nullable()->comment('事件相關照片路徑');
            $table->enum('event_type', ['birth', 'adoption', 'medical', 'milestone', 'special', 'death', 'other'])->default('other')->comment('事件類型');
            $table->integer('display_order')->default(0)->comment('顯示順序');
            $table->boolean('is_visible')->default(true)->comment('是否顯示');
            $table->timestamps();
            $table->index(['pet_id', 'event_date']);
            $table->index('event_type');
            $table->index('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timeline_events');
    }
};
