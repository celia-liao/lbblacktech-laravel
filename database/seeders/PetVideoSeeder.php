<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PetVideo;
use App\Models\Pet;

class PetVideoSeeder extends Seeder
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

        // 封面影片 (header category)
        $headerVideos = [
            // 目前是空的，可以在這裡添加
        ];
        
        // 泡泡影片 (bubble category)
        $bubbleVideos = [
            
        ];
        
        // 走廊影片 (corridor category)
        $corridorVideos = [
            // 目前是空的，可以在這裡添加
        ];
        
        // 建立所有影片
        $allVideos = array_merge($headerVideos, $bubbleVideos, $corridorVideos);
        
        foreach ($allVideos as $index => $video) {
            PetVideo::create([
                'pet_id' => $pet->pet_id,
                'video_path' => $video['video_path'],
                'text' => $video['text'],
                'ratio' => $video['ratio'],
                'sound' => $video['sound'],
                'category' => $video['category'],
                'display_order' => $index + 1,
                'is_active' => true,
            ]);
        }
        
        $this->command->info("成功建立 " . count($allVideos) . " 個影片記錄");
    }
}
 