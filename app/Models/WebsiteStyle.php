<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteStyle extends Model
{
    use HasFactory;
    protected $primaryKey = 'style_id';
    protected $fillable = [
        'pet_id',
        'loading_color',
        'cover_name_color',
        'cover_circle_color',
        'header_love_color',
        'header_footprint_color',
        'day_text_color',
        'title_color',
        'handshake_button_color',
        'videos_button_color',
        'bubble_ball_color',
        'bubble_background',
        'footprint_color',
        'footer_background_color',
        'function_color',
        'function_background_color',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }
}
