<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\StoresPetImages;

class PhotoGallery extends Model
{
    use HasFactory, StoresPetImages;

    protected $primaryKey = 'photo_id';

    protected $fillable = [
        'pet_id',
        'photo_path',
        'photo_category',
        'display_order',
        'is_active'
    ];

    protected static function booted()
    {
        static::saving(function ($gallery) {
            if (request()->hasFile('photo_path')) {
                $gallery->photo_path = $gallery->storePhotoGalleryImage(request()->file('photo_path'), $gallery->photo_category);
            }
            if (request()->hasFile('original_image')) {
                $gallery->original_image = $gallery->storePhotoGalleryImage(request()->file('original_image'), $gallery->photo_category);
            }
        });
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    public function getStoragePath($filename)
    {
        return $this->getPhotoGalleryImageUrl($filename);
    }
}
