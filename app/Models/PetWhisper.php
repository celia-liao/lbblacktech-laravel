<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetWhisper extends Model
{
    use HasFactory;

    protected $primaryKey = 'whisper_id';

    protected $fillable = [
        'pet_id',
        'content'
    ];

    /**
     * 與Pet模型的關聯
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    /**
     * 獲取隨機小語（優先使用該寵物的自定義小語，如果沒有則使用預設小語）
     */
    public static function getRandomWhisper($petId)
    {
        // 先嘗試獲取該寵物的自定義小語
        $customWhisper = self::where('pet_id', $petId)
            ->inRandomOrder()
            ->first();

        if ($customWhisper) {
            return $customWhisper;
        }

        // 如果沒有自定義小語，則使用預設小語
        return self::whereNull('pet_id')
            ->inRandomOrder()
            ->first();
    }

    /**
     * 獲取該寵物的所有小語（包含預設）
     */
    public static function getPetWhispers($petId)
    {
        return self::where(function($query) use ($petId) {
            $query->where('pet_id', $petId)
                  ->orWhereNull('pet_id');
        })
        ->orderBy('pet_id', 'asc')
        ->get();
    }
}
