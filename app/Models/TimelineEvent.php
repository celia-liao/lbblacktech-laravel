<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id', 'event_date', 'age_years', 'age_months', 'age_days',
        'event_title', 'event_description', 'event_photo', 'background',
        'original_image', 'event_type', 'display_order', 'is_visible'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
