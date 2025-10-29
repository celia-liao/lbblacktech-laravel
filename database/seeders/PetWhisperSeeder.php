<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PetWhisper;

class PetWhisperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 通用預設小語（所有寵物都可使用，當沒有自定義小語時使用）
        $defaultWhispers = [
            '主人，你今天過得好嗎？我想你了～',
            '要記得好好吃飯喔！我會一直陪著你的',
            '今天天氣真好，我們一起出去玩吧！',
            '主人，抱抱～我最喜歡你了',
            '不要難過，我會一直陪在你身邊的',
            '今天也要加油喔！我相信你可以的',
            '主人，我偷偷告訴你一個秘密...我超愛你的！',
            '夜深了，要早點休息喔，我會守護你的夢',
            '主人，你今天看起來有點累，要不要休息一下？',
            '不管發生什麼事，我都會在你身邊支持你的',
            '主人，我們一起創造更多美好的回憶吧！',
            '雖然我不能說話，但我的心意你一定感受得到',
            '主人，你是我生命中最重要的人',
            '今天也要保持微笑喔！你的笑容是我最喜歡的',
            '主人，謝謝你一直這麼愛我，我也很愛你'
        ];

        foreach ($defaultWhispers as $content) {
            PetWhisper::create([
                'pet_id' => null,
                'content' => $content
            ]);
        }
    }
}
