<?php

namespace Database\Seeders;

use App\Models\Pet;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PetSeeder extends Seeder
{
    public function run(): void
    {
        Pet::create([
            'name' => '糖糖',
            'slug' => 'tang-tang-20040501',
            'birth_date' => Carbon::create(2004, 5, 1),
            'target_days' => 6145,
            'creation_date' => '2025/01/21',
            
            // 封面區塊
            'cover_message' => '糖糖，感謝妳來到我們的生活中<br>希望妳一直都是快樂的小天使。',
            'header_videos' => [
                "./image/header/video/cover_01.mp4",
                "./image/header/video/cover_04.mp4"
            ],
            'header_images' => [
                "./image/header/photo/cover_05.webp",
                "./image/header/photo/cover_06.webp",
                "./image/header/photo/cover_07.webp",
                "./image/header/photo/cover_08.webp",
                "./image/header/photo/cover_09.webp",
                "./image/header/photo/cover_10.webp"
            ],
            
            // 生命軌跡 (從setting.js複製)
            'life_timeline' => [
                [
                    "age" => "3個月",
                    "title" => "這年夏天<br>你來到我生命中",
                    "text" => "你說我叫糖糖嗎?",
                    "background" => "./image/main/life/background/s1-background.svg",
                    "image" => "./image/main/life/photo/life_01.webp",
                    "originalImage" => "./image/main/life/photo/original/life_01.webp"
                ],
                [
                    "age" => "1歲",
                    "title" => "最喜歡抱抱了",
                    "text" => "我也不會放開你的喔",
                    "background" => "./image/main/life/background/s2-background.svg",
                    "image" => "./image/main/life/photo/life_02.webp",
                    "originalImage" => "./image/main/life/photo/original/life_02.webp"
                ],
                // ... 更多軌跡節點
                [
                    "age" => "現在",
                    "ending" => "我想在這裡陪你很久很久"
                ]
            ],
            
            // 記憶迴廊
            'corridor_total_images' => 30,
            'corridor_videos' => [],
            'corridor_picture_num' => 12,
            
            // 泡泡互動
            'bubble_images' => [
                [
                    "large" => "./image/main/bobs/photo/original/bubble_01.webp",
                    "small" => "./image/main/bobs/photo/bubble_01.webp"
                ],
                // ... 更多泡泡圖片
            ],
            'bubble_videos' => [
                [
                    "src" => "./image/main/interaction/photo/coming_eat.mp4",
                    "text" => "吃飯",
                    "ratio" => "long",
                    "sound" => false
                ],
                [
                    "src" => "./image/main/interaction/photo/coming_call.mp4",
                    "text" => "呼喚",
                    "ratio" => "long",
                    "sound" => true
                ]
            ],
            
            // 信件內容
            'letter_content' => '妳來到我們的生命中，陪伴著我們將近20年的歲月，陪伴著我大學跟研究所的生涯...',
            
            // 顏色主題 (從setting.js複製)
            'loading_color' => '#f7d6dc',
            'cover_day_timeline_color' => '#f4879c',
            'header_love_color' => '#f4879c',
            'header_footprint_color' => '#ffc5ea',
            'day_text_age_color' => '#752c3a',
            'title_color' => '#c696a6',
            'handshake_button_color' => '#cc96ff',
            'videos_button_color' => '#ff91bf',
            'bubble_ball_color' => '#ffd2d5',
            'bubble_background_gradient' => 'linear-gradient(180deg, rgba(255, 241, 229, 0) 0%, rgb(255, 229, 231) 81.6%)',
            'footprint_all_color' => '#f7cfda',
            'footer_background_color' => '#ffdce3',
            'function_color' => '#C696A6',
            'function_background_color' => 'rgba(255, 220, 227, 0.9)',
            
            'is_public' => true
        ]);
    }
}
