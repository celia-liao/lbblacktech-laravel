<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Letter;
use App\Models\Pet;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pet = Pet::where('website_slug', 'ruby-20130701')->first();
        
        if ($pet) {
            Letter::create([
                'pet_id' => $pet->pet_id,
                'letter_content' => '嚕比，妳離開我們的日子已經七年了，對妳的思念厚厚一疊，依舊那麼清晰，謝謝妳是這麼貼心溫暖的存在，讓我的每一天都好幸福，覺得被愛著、被需要著。謝謝妳教會我什麼是愛，我時常想念著妳大大的頭，雙手環抱妳那毛茸茸溫暖的身體，熱呼呼黏稠的口水，還有那些我訓練妳的技能，我們一起在公園玩耍的回憶，今生能夠與妳相遇，是我這一輩子最幸福的事！我等妳用不同的方式再回到我身邊喔！',
            ]);
        }
    }
}
