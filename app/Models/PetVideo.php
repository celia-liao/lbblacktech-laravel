<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\StoresPetImages;

class PetVideo extends Model
{
    use HasFactory, StoresPetImages;

    protected $primaryKey = 'video_id';

    protected $fillable = [
        'pet_id',
        'video_path',
        'category',
        'display_order',
        'is_active',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    protected static function booted()
    {
        static::saving(function ($video) {
            $request = request(); // 避免 CLI 出錯

            if ($request && $request->hasFile('video_path')) {
                $video->video_path = $video->storePetVideo($request->file('video_path'));
            }
        });
    }
}
