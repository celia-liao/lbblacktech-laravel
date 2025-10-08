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
    }
}
