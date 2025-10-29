<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Pet extends Model
{
    use HasFactory;

    protected $primaryKey = 'pet_id';

    protected $fillable = [
        'pet_name',
        'breed',
        'website_slug',
        'line_user_id',
        'personality',
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

    public function petButtons()
    {
        return $this->hasMany(\App\Models\PetButton::class, 'pet_id', 'pet_id');
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

    public function petWhispers()
    {
        return $this->hasMany(\App\Models\PetWhisper::class, 'pet_id', 'pet_id');
    }

    /**
     * 獲取寵物個性的完整資訊
     * 
     * @return array|null
     */
    public function getPersonalityInfo()
    {
        if (!$this->personality) {
            return null;
        }
        
        $personalities = config('pet_personalities');
        return $personalities[$this->personality] ?? null;
    }

    /**
     * 獲取個性名稱
     * 
     * @return string|null
     */
    public function getPersonalityNameAttribute()
    {
        $info = $this->getPersonalityInfo();
        return $info ? $info['名稱'] : null;
    }

    /**
     * 模型啟動方法
     * 當儲存 Pet 時自動生成字體子集
     */
    protected static function booted()
    {
        static::saving(function ($pet) {
            // 只有當 slogan 和 website_slug 都存在時才執行
            if (!empty($pet->slogan) && !empty($pet->website_slug)) {
                try {
                    \App\Services\FontSubsetService::generateSubset(
                        $pet->slogan, 
                        $pet->website_slug
                    );
                } catch (\Exception $e) {
                    // 記錄錯誤但不中斷儲存流程
                    Log::error('字體子集生成失敗：' . $e->getMessage(), [
                        'pet_id' => $pet->pet_id,
                        'slug' => $pet->website_slug,
                        'slogan' => $pet->slogan
                    ]);
                    
                    // 如果需要中斷儲存，可以拋出異常
                    // throw $e;
                }
            }
        });
    }
}
