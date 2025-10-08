<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $primaryKey = 'pet_id';

    protected $fillable = [
        'pet_name',
        'breed',
        'website_slug',
        'slogan',
        'is_active'
    ];

    // 定義與其他模型的關聯
    public function timelineEvents()
    {
        return $this->hasMany(TimelineEvent::class, 'pet_id', 'pet_id');
    }

    public function photoGalleries()
    {
        return $this->hasMany(PhotoGallery::class, 'pet_id', 'pet_id');
    }

    public function lifeSlides()
    {
        return $this->hasMany(\App\Models\LifeSlide::class, 'pet_id', 'pet_id');
    }

    public function petVideos()
    {
        return $this->hasMany(\App\Models\PetVideo::class, 'pet_id', 'pet_id');
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
