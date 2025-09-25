<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\StoresPetImages;

class LifeSlide extends Model
{
    use HasFactory, StoresPetImages;

    protected $primaryKey = 'life_slide_id';

    protected $fillable = [
        'pet_id',
        'life_slide_image',
        'life_slide_video',
        'is_active',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    protected static function booted()
    {
        static::saving(function ($slide) {
            $request = request(); // ✅ 避免 CLI 出錯


            if ($request && $request->hasFile('life_slide_image')) {
                $slide->life_slide_image = $slide->storeLifeSlide($request->file('life_slide_image'), 'image');
            }

            if ($request && $request->hasFile('life_slide_video')) {
                $slide->life_slide_video = $slide->storeLifeSlide($request->file('life_slide_video'), 'video');
            }
        });
    }
}
