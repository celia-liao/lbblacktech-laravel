<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\StoresPetImages;
use Illuminate\Support\Facades\Log; 

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
            // 添加調試日誌
            Log::info('PetButton saving event triggered', [
                'button_id' => $button->button_id,
                'button_text' => $button->button_text,
                'pet_id' => $button->pet_id
            ]);

            $request = request();

            // 處理媒體檔案上傳
            if ($request && $request->hasFile('media_path')) {
                $file = $request->file('media_path');
                
                if ($button->button_type === 'image') {
                    $button->media_path = $button->storePetImage($file, 'button');
                } elseif ($button->button_type === 'video') {
                    $button->media_path = $button->storePetVideo($file, 'button');
                }
            }

            // 處理字體子集生成
            if (!empty($button->button_text)) {
                // 獲取關聯的 Pet
                $pet = $button->pet;
                
                if ($pet && !empty($pet->website_slug)) {
                    try {
                        Log::info('Generating font subset for PetButton', [
                            'button_text' => $button->button_text,
                            'slug' => $pet->website_slug
                        ]);
                        
                        \App\Services\FontSubsetService::generateGenSenRoundedSubset(
                            $pet->website_slug
                        );
                        
                        Log::info('Font subset generation completed for PetButton');
                    } catch (\Exception $e) {
                        // 記錄錯誤但不中斷流程
                        Log::error('PetButton 字體子集生成失敗：' . $e->getMessage(), [
                            'pet_id' => $button->pet_id,
                            'slug' => $pet->website_slug,
                            'button_text' => $button->button_text
                        ]);
                    }
                }
            }
        });
    }   
}
