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
        
        if ($pet) {
            // 封面影片 (header_videos) - 目前是空的
            // 泡泡影片 (bubble_videos)
            $bubbleVideos = [
                [
                    'video_path' => '砰.mp4',
                    'text' => '砰!',
                    'ratio' => 'tall',
                    'sound' => true,
                    'category' => 'bubble',
                ],
                [
                    'video_path' => 'coming_eat.mp4',
                    'text' => '吃飯',
                    'ratio' => 'tall',
                    'sound' => false,
                    'category' => 'bubble',
                ],
                [
                    'video_path' => '吃飯.mp4',
                    'text' => '吃飯',
                    'ratio' => 'tall',
                    'sound' => true,
                    'category' => 'bubble',
                ],
            ];
            
            foreach ($bubbleVideos as $index => $video) {
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
            
            // 記憶迴廊影片 (corridor_videos)
            for ($i = 1; $i <= 16; $i++) {
                $paddedNumber = str_pad($i, 2, '0', STR_PAD_LEFT);
                $videoName = "film_{$paddedNumber}.mp4";
                
                PetVideo::create([
                    'pet_id' => $pet->pet_id,
                    'video_path' => $videoName,
                    'text' => null,
                    'ratio' => 'tall',
                    'sound' => false,
                    'category' => 'corridor',
                    'display_order' => $i,
                    'is_active' => true,
                ]);
            }
        }
    }
}
