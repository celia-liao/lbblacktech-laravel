<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id', 'theme_color', 'secondary_color', 'background_type',
        'background_value', 'font_family', 'font_size', 'layout_style',
        'auto_play_music', 'show_visitor_count', 'show_timeline',
        'show_gallery', 'show_messages', 'enable_animations',
        'custom_css', 'custom_js', 'meta_title',
        'meta_description', 'meta_keywords',
        'life_timeline_animation_duration', 'corridor_random_image_count',
        'description', 'slogan', 'creation_date'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
