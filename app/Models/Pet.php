<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $primaryKey = 'pet_id';

    protected $fillable = [
        'pet_name', 'pet_type', 'breed', 'birth_date', 'death_date',
        'main_photo', 'website_slug', 'owner_name',
        'owner_email', 'is_active'
    ];

    // 定義與其他模型的關聯
    public function timelineEvents()
    {
        return $this->hasMany(TimelineEvent::class, 'pet_id', 'pet_id');
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

    public function letter()
    {
        return $this->hasOne(\App\Models\Letter::class, 'pet_id'); 
    }

    public function websiteSetting()
    {
        return $this->hasOne(\App\Models\WebsiteSetting::class, 'pet_id'); 
    }

    public function websiteStyle()
    {
        return $this->hasOne(\App\Models\WebsiteStyle::class, 'pet_id'); 
    }


}
