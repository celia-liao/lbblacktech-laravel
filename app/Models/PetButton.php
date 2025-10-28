<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\StoresPetImages;

class PetButton extends Model
{
    use HasFactory, StoresPetImages;

    protected $primaryKey = 'button_id';

    protected $fillable = [
        'pet_id',
        'button_type',
        'button_text',
        'media_path',
        'ratio',
        'sound',
        'is_active',
    ];

    protected $casts = [
        'sound' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    /**
     * 獲取按鈕配置
     */
    public function getButtonConfig()
    {
        $config = [
            'id' => $this->button_id,
            'type' => $this->button_type,
            'text' => $this->button_text,
            'media_path' => $this->media_path,
            'active' => $this->is_active,
        ];

        // 如果是影片類型，添加影片相關配置
        if ($this->button_type === 'video') {
            $config['ratio'] = $this->ratio;
            $config['sound'] = $this->sound;
        }

        return $config;
    }

    /**
     * 模型啟動方法
     * 當儲存 PetButton 時自動處理媒體檔案上傳
     */
    protected static function booted()
    {
        static::saving(function ($button) {
            $request = request();

            if ($request && $request->hasFile('media_path')) {
                $file = $request->file('media_path');
                
                if ($button->button_type === 'image') {
                    $button->media_path = $button->storePetImage($file, 'button');
                } elseif ($button->button_type === 'video') {
                    $button->media_path = $button->storePetVideo($file, 'button');
                }
            }
        });
    }   
}
