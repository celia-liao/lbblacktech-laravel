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
        Schema::table('website_styles', function (Blueprint $table) {
            $table->string('cover_circle_color', 20)->default('rgb(255, 191, 117)')->comment('封面圈圈顏色 (coverName_dayNumbers_dayTimeline)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_styles', function (Blueprint $table) {
            $table->dropColumn('cover_circle_color');
        });
    }
};
