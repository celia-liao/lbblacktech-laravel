<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhotoGallery;
use App\Models\Pet;

class PhotoGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pet = Pet::where('website_slug', 'ruby-20130701')->first();
        
        if ($pet) {
            // 封面照片 (header_imageList)
            $headerImages = [
                'cover_01.webp',
                'cover_02.webp',
                'cover_03.webp',
                'cover_04.webp',
                'cover_05.webp',
                'cover_06.webp',
                'cover_07.webp',
            ];
            
            foreach ($headerImages as $index => $image) {
                PhotoGallery::create([
                    'pet_id' => $pet->pet_id,
                    'photo_path' => $image,
                    'photo_category' => 'header',
                    'original_image' => $image,
                    'display_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
            
            // 泡泡照片 (bubble_imagePaths)
            $bubbleImages = [
                ['small' => 'bubble_01.webp', 'large' => 'bubble_01.webp'],
                ['small' => 'bubble_02.webp', 'large' => 'bubble_02.webp'],
                ['small' => 'bubble_03.webp', 'large' => 'bubble_03.webp'],
                ['small' => 'bubble_04.webp', 'large' => 'bubble_04.webp'],
                ['small' => 'bubble_05.webp', 'large' => 'bubble_05.webp'],
                ['small' => 'bubble_06.webp', 'large' => 'bubble_06.webp'],
            ];
            
            foreach ($bubbleImages as $index => $bubble) {
                // 小圖
                PhotoGallery::create([
                    'pet_id' => $pet->pet_id,
                    'photo_path' => $bubble['small'],
                    'photo_category' => 'bubble_small',
                    'original_image' => $bubble['large'],
                    'display_order' => $index + 1,
                    'is_active' => true,
                ]);
                
                // 大圖
                PhotoGallery::create([
                    'pet_id' => $pet->pet_id,
                    'photo_path' => $bubble['large'],
                    'photo_category' => 'bubble_large',
                    'original_image' => $bubble['large'],
                    'display_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
            
            // 記憶迴廊照片 (corridor_images)
            for ($i = 1; $i <= 22; $i++) {
                $paddedNumber = str_pad($i, 2, '0', STR_PAD_LEFT);
                $imageName = "film_{$paddedNumber}.webp";
                
                PhotoGallery::create([
                    'pet_id' => $pet->pet_id,
                    'photo_path' => $imageName,
                    'photo_category' => 'corridor',
                    'original_image' => $imageName,
                    'display_order' => $i,
                    'is_active' => true,
                ]);
            }
        }
    }
}
