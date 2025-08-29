<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'video_path',
        'text',
        'ratio',
        'sound',
        'category',
        'is_active',
    ];
}
