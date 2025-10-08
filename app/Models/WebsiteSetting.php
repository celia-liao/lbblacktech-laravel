<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $primaryKey = 'setting_id';

    protected $fillable = [
        'pet_id',
        'target_number',
        'duration',
        'corridor_random_image_count',
        'creation_date'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }
}
