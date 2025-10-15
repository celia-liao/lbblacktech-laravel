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
        Schema::table('pets', function (Blueprint $table) {
            $table->string('line_user_id', 100)->nullable()->after('website_slug')->comment('LINE用戶ID');
            $table->string('personality', 20)->nullable()->default('easygoing')->after('line_user_id')->comment('寵物個性類型: sunny, foodie, tsundere, easygoing, otaku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['line_user_id', 'personality']);
        });
    }
};
