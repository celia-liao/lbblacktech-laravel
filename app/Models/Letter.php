<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Letter extends Model
{
    use HasFactory;

    protected $primaryKey = 'letter_id';

    protected $fillable = [
        'pet_id',
        'letter_content',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    /**
     * 模型啟動方法
     * 當儲存 Letter 時自動生成字體子集
     */
    protected static function booted()
    {
        static::saving(function ($letter) {
            // 只有當 letter_content 存在時才執行
            if (!empty($letter->letter_content)) {
                // 獲取關聯的 Pet
                $pet = $letter->pet;
                
                if ($pet && !empty($pet->website_slug)) {
                    try {
                        \App\Services\FontSubsetService::generateSubset(
                            $letter->letter_content, 
                            $pet->website_slug
                        );
                    } catch (\Exception $e) {
                        // 記錄錯誤但不中斷儲存流程
                        Log::error('Letter 字體子集生成失敗：' . $e->getMessage(), [
                            'letter_id' => $letter->letter_id,
                            'pet_id' => $letter->pet_id,
                            'slug' => $pet->website_slug,
                            'content' => $letter->letter_content
                        ]);
                        
                        // 如果需要中斷儲存，可以拋出異常
                        // throw $e;
                    }
                }
            }
        });
    }
}
