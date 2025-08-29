<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebsiteSetting;
use App\Models\Pet;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pet = Pet::where('website_slug', 'ruby-20130701')->first();
        
        if ($pet) {
            WebsiteSetting::create([
                'pet_id' => $pet->pet_id,
                'target_number' => 4380, // targetNumber
                'duration' => 4000, // duration
                'corridor_random_image_count' => 12, // pictureNum
                'creation_date' => '2025/03/07', // startDateStr
            ]);
        }
    }
}
