<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PetButton;
use App\Models\Pet;

class PetButtonSeeder extends Seeder
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

        // 圖片按鈕 (image type)
        $imageButtons = [
            [
                'button_text' => '握手',
                'media_path' => 'hand-p.webp',
                'button_type' => 'image',
            ],
            // 可以在這裡添加更多圖片按鈕
        ];
        
        // 影片按鈕 (video type)
        $videoButtons = [
            [
                'button_text' => '吃飯',
                'media_path' => 'coming_eat.mp4',
                'button_type' => 'video',
                'ratio' => 'tall',
                'sound' => false,
            ],
            [
                'button_text' => '麥味登',
                'media_path' => 'mcd.mp4',
                'button_type' => 'video',
                'ratio' => 'tall',
                'sound' => true,
            ],
            // 可以在這裡添加更多影片按鈕
        ];
        
        // 建立所有按鈕
        $allButtons = array_merge($imageButtons, $videoButtons);
        
        foreach ($allButtons as $button) {
            PetButton::create([
                'pet_id' => $pet->pet_id,
                'button_type' => $button['button_type'],
                'button_text' => $button['button_text'],
                'media_path' => $button['media_path'] ?? null,
                'ratio' => $button['ratio'] ?? null, // 僅影片類型需要
                'sound' => $button['sound'] ?? false, // 僅影片類型需要
                'is_active' => true,
            ]);
        }
        
        $this->command->info("成功建立 " . count($allButtons) . " 個按鈕記錄");
    }
}

