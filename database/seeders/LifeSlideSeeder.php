<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pet;
use App\Models\LifeSlide;

class LifeSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pet = Pet::where('website_slug', 'ruby-20130701')->first();
        
        if (!$pet) {
            $this->command->warn('找不到 website_slug 為 ruby-20130701 的寵物');
            return;
        }

        // 記憶迴廊照片 (corridor_images) - 16 張
        $slides = [];
        for ($i = 1; $i <= 16; $i++) {
            $paddedNumber = str_pad($i, 2, '0', STR_PAD_LEFT);
            $imageName = "film_{$paddedNumber}.webp";
            $videoName = "film_{$paddedNumber}.mp4";
            
            $slides[] = [
                'pet_id' => $pet->pet_id,
                'life_slide_image' => $imageName,
                'life_slide_media' => $videoName, // 使用 model fillable 中的字段名
                'is_active' => true,
            ];
        }
        
        // 批量建立
        foreach ($slides as $slide) {
            LifeSlide::create($slide);
        }
        
        $this->command->info("成功建立 " . count($slides) . " 個輪播圖記錄");
    }
}
