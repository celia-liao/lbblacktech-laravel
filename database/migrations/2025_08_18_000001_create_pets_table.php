<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->comment('寵物基本資料表');
            $table->id('pet_id')->comment('寵物ID');
            $table->string('pet_name', 100)->comment('寵物名稱 (如：里長、糖糖、嚕比)');
            $table->string('pet_type', 50)->nullable()->comment('寵物類型 (狗狗/貓咪/鼠寶/兔寶/鳥寶/爬寶/其他寶貝)');
            $table->string('breed', 100)->nullable()->comment('品種 (馬爾濟斯/黃金獵犬/三花貓/米克斯)');
            $table->date('birth_date')->nullable()->comment('出生日期');
            $table->date('death_date')->nullable()->comment('離世日期');
            $table->integer('life_days')->storedAs('DATEDIFF(death_date, birth_date)')->comment('生命天數 (自動計算)');
            $table->text('description')->nullable()->comment('寵物描述/故事');
            $table->string('main_photo', 500)->nullable()->comment('主要照片路徑');
            $table->string('website_slug', 100)->unique()->comment('網站識別碼 (如：length-20181225)');
            $table->string('owner_name', 100)->nullable()->comment('主人姓名');
            $table->string('owner_email', 200)->nullable()->comment('主人聯絡信箱');
            $table->boolean('is_active')->default(true)->comment('網站是否啟用');
            $table->timestamps();
            $table->index('pet_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
