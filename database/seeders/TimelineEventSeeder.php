<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimelineEvent;
use App\Models\Pet;

class TimelineEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pet = Pet::where('website_slug', 'ruby-20130701')->first();
        
        if ($pet) {
            $lifeData = [
                [
                    'age' => '10歲',
                    'event_title' => '跟阿莫一起',
                    'event_description' => '曬曬太陽！',
                    'background' => 's1-background.svg',
                    'event_photo' => 'life_09.webp',
                    'original_image' => 'life_09.webp',
                    'is_ending' => false,
                    'display_order' => 1,
                ],
                [
                    'age' => '11歲',
                    'event_title' => '最愛的大草皮<br>還有黃色啾啾球',
                    'event_description' => '我玩到好累，<br>口水都滴下來了！',
                    'background' => 's1-background.svg',
                    'event_photo' => 'life_01.webp',
                    'original_image' => 'life_01.webp',
                    'is_ending' => false,
                    'display_order' => 2,
                ],
                [
                    'age' => '11歲',
                    'event_title' => '狗狗水世界！',
                    'event_description' => '我是水中蛟龍喔～<br>還會潛水呢！',
                    'background' => 's2-background.svg',
                    'event_photo' => 'life_02.webp',
                    'original_image' => 'life_02.webp',
                    'is_ending' => false,
                    'display_order' => 3,
                ],
                [
                    'age' => '11歲',
                    'event_title' => '我擺好POSE了！',
                    'event_description' => '這樣有可愛嗎？',
                    'background' => 's3-background.svg',
                    'event_photo' => 'life_03.webp',
                    'original_image' => 'life_03.webp',
                    'is_ending' => false,
                    'display_order' => 4,
                ],
                [
                    'age' => '11歲',
                    'event_title' => '頂食物<br>可是我的拿手絕活！',
                    'event_description' => '這也是我媽教我的技能喔！<br>厲害了吧！',
                    'background' => 's4-background.svg',
                    'event_photo' => 'life_04.webp',
                    'original_image' => 'life_04.webp',
                    'is_ending' => false,
                    'display_order' => 5,
                ],
                [
                    'age' => '11歲',
                    'event_title' => '不要以為<br>黃金獵犬都是溫馴的！',
                    'event_description' => '我是會看家的喔！<br>陌生人要進家門？<br>先過我這關！',
                    'background' => 's2-background.svg',
                    'event_photo' => 'life_06.webp',
                    'original_image' => 'life_06.webp',
                    'is_ending' => false,
                    'display_order' => 6,
                ],
                [
                    'age' => '11歲',
                    'event_title' => '我還有一隻小跟班，<br>阿莫！',
                    'event_description' => '時常一直煩我的黏人精！',
                    'background' => 's3-background.svg',
                    'event_photo' => 'life_07.webp',
                    'original_image' => 'life_07.webp',
                    'is_ending' => false,
                    'display_order' => 7,
                ],
                [
                    'age' => '11歲',
                    'event_title' => '天氣好冷',
                    'event_description' => '跟小傢伙一起取暖蓋被被吧！',
                    'background' => 's4-background.svg',
                    'event_photo' => 'life_08.webp',
                    'original_image' => 'life_08.webp',
                    'is_ending' => false,
                    'display_order' => 8,
                ],
                [
                    'age' => '11歲',
                    'event_title' => '哎唷不錯喔',
                    'event_description' => '我穿這樣還滿帥的吧！',
                    'background' => 's2-background.svg',
                    'event_photo' => 'life_10.webp',
                    'original_image' => 'life_10.webp',
                    'is_ending' => false,
                    'display_order' => 9,
                ],
                [
                    'age' => '12歲',
                    'event_title' => '我還能這樣<br>兩腳舉高高的頂食物喔！',
                    'event_description' => '看來我可以去參加馬戲團了！',
                    'background' => 's1-background.svg',
                    'event_photo' => 'life_05.webp',
                    'original_image' => 'life_05.webp',
                    'is_ending' => false,
                    'display_order' => 10,
                ],
                [
                    'age' => '現在',
                    'event_title' => '我想在這裡陪你很久很久',
                    'event_description' => null,
                    'background' => null,
                    'event_photo' => null,
                    'original_image' => null,
                    'is_ending' => true,
                    'display_order' => 11,
                ],
            ];
            
            foreach ($lifeData as $event) {
                TimelineEvent::create([
                    'pet_id' => $pet->pet_id,
                    'age' => $event['age'],
                    'event_title' => $event['event_title'],
                    'event_description' => $event['event_description'],
                    'background' => $event['background'],
                    'event_photo' => $event['event_photo'],
                    'original_image' => $event['original_image'],
                    'is_ending' => $event['is_ending'],
                    'display_order' => $event['display_order'],
                    'is_visible' => true,
                ]);
            }
        }
    }
}
