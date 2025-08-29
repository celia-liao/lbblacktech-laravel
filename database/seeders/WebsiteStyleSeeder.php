<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebsiteStyle;
use App\Models\Pet;

class WebsiteStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pet = Pet::where('website_slug', 'ruby-20130701')->first();
        
        if ($pet) {
            WebsiteStyle::create([
                'pet_id' => $pet->pet_id,
                'loading_color' => '#f7d6dc', // loading_color
                'cover_name_color' => '#f4879c', // coverName_dayNumbers_dayTimeline
                'header_love_color' => 'rgba(244, 135, 156, 0.3)', // header_love
                'header_footprint_color' => '#ffc5ea', // header_footprint
                'day_text_color' => 'rgb(117, 24, 58)', // dayText_dayAge
                'title_color' => 'rgb(198, 150, 166)', // title_color
                'handshake_button_color' => '#cc96ff', // handshake_button
                'videos_button_color' => '#ff91bf', // videos_button
                'bubble_ball_color' => '#ffd2d5', // bubble_ball
                'bubble_background' => 'linear-gradient(180deg, rgba(255, 241, 229, 0) 0%, rgb(255, 229, 231) 81.6%)', // bubble_background
                'footprint_color' => '#f7cfda', // footprint_all
                'footer_background_color' => 'rgb(255, 220, 227)', // footer_background
                'function_color' => '#C696A6', // function_color
                'function_background_color' => 'rgba(255, 220, 227, 0.9)', // function_background
            ]);
        }
    }
}
