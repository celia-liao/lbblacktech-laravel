<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_messages', function (Blueprint $table) {
            $table->comment('訪客留言表');
            $table->id('message_id')->comment('留言ID');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade')->comment('寵物ID');
            $table->string('visitor_name', 100)->comment('訪客姓名');
            $table->string('visitor_email', 200)->nullable()->comment('訪客信箱 (可選)');
            $table->string('visitor_relation', 50)->nullable()->comment('與寵物的關係 (朋友/鄰居/獸醫師/其他)');
            $table->text('message_content')->comment('留言內容');
            $table->enum('message_type', ['condolence', 'memory', 'blessing', 'other'])->default('memory')->comment('留言類型');
            $table->boolean('is_approved')->default(false)->comment('是否通過審核');
            $table->boolean('is_public')->default(true)->comment('是否公開顯示');
            $table->string('ip_address', 45)->nullable()->comment('IP地址');
            $table->text('user_agent')->nullable()->comment('瀏覽器資訊');
            $table->text('reply_content')->nullable()->comment('管理員回覆');
            $table->timestamp('reply_date')->nullable()->comment('回覆時間');
            $table->timestamps();
            $table->index(['pet_id', 'is_approved']);
            $table->index('message_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_messages');
    }
};
