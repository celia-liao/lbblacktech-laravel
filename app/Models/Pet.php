<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_name', 'pet_type', 'breed', 'birth_date', 'death_date',
        'description', 'main_photo', 'website_slug', 'owner_name',
        'owner_email', 'is_active'
    ];

    // 定义与其他模型的关系
    public function timelineEvents()
    {
        return $this->hasMany(TimelineEvent::class);
    }

    public function photoGalleries()
    {
        return $this->hasMany(PhotoGallery::class);
    }

    public function musicPlaylists()
    {
        return $this->hasMany(MusicPlaylist::class);
    }

    public function visitorMessages()
    {
        return $this->hasMany(VisitorMessage::class);
    }

    public function websiteSettings()
    {
        return $this->hasOne(WebsiteSetting::class);
    }

    public function websiteAnalytics()
    {
        return $this->hasMany(WebsiteAnalytics::class);
    }
}
