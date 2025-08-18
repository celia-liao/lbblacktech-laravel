<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id', 'gallery_name', 'photo_path', 'photo_title',
        'photo_caption', 'photo_category', 'file_size', 'file_type',
        'width', 'height', 'upload_date', 'display_order',
        'is_visible', 'view_count'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
