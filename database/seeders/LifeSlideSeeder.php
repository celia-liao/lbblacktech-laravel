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
        //
        $pet = Pet::where('website_slug', 'ruby-20130701')->first();
        if ($pet) {
            // 記憶迴廊照片 (corridor_images)
            for ($i = 1; $i <= 16; $i++) {
                $paddedNumber = str_pad($i, 2, '0', STR_PAD_LEFT);
                $imageName = "film_{$paddedNumber}.webp";
                $videoName = "film_{$paddedNumber}.mp4";
                
                LifeSlide::create([
                    'pet_id' => $pet->pet_id,
                    'life_slide_image' => $imageName,
                    'life_slide_video' => $videoName,
                    'is_active' => true,
                ]);
            }
        }
    }
}
