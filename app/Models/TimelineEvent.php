<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\StoresPetImages;

class TimelineEvent extends Model
{
    use StoresPetImages; // ✅ 套用 Trait

    protected $table = 'timeline_events';
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'age',
        'event_title',
        'event_description',
        'background',
        'event_photo',
        'original_image',
        'is_ending',
        'is_visible',
        'display_order',
        'pet_id', // 確保外鍵也能被存
    ];

    /**
     * 關聯到 Pet
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    /**
     * 在儲存時，檢查是否有圖片要上傳
     */
    protected static function booted()
    {
        static::saving(function ($event) {
            foreach (['background', 'event_photo', 'original_image'] as $field) {
                if (request()->hasFile($field)) {
                    // 用 Trait 的方法來存檔
                    // 將欄位名稱映射到對應的 type
                    $type = match ($field) {
                        'event_photo' => 'photo',
                        'original_image' => 'original',
                        default => $field,
                    };
                    $event->$field = $event->storePetImage(request()->file($field), $type);
                }
            }
        });

        // 儲存後生成 GenSenRounded 字體
        static::saved(function ($event) {
            // 只有當 event_title 或 event_description 存在時才執行
            if (!empty($event->event_title) || !empty($event->event_description)) {
                // 獲取關聯的 Pet
                $pet = $event->pet;
                
                if ($pet && !empty($pet->website_slug)) {
                    try {
                        \App\Services\FontSubsetService::generateGenSenRoundedSubset(
                            $pet->website_slug
                        );
                    } catch (\Exception $e) {
                        // 記錄錯誤但不中斷流程
                        \Illuminate\Support\Facades\Log::error('TimelineEvent 字體子集生成失敗：' . $e->getMessage(), [
                            'event_id' => $event->event_id,
                            'pet_id' => $event->pet_id,
                            'slug' => $pet->website_slug,
                            'title' => $event->event_title,
                            'description' => $event->event_description
                        ]);
                    }
                }
            }
        });
    }
}
