<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pet;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pet::create([
            'pet_name' => '嚕比',
            'website_slug' => 'ruby-20130701',
            'slogan' => '嚕比，謝謝妳<br>豐富了我國小到大學的生活，<br>我們之間雖然已成過去式，<br>但妳一直都活在我的心中！<br>我永遠愛妳！',
            'is_active' => true,
        ]);
    }
}
