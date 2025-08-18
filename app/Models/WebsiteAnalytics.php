<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id', 'visit_date', 'visitor_count', 'page_views',
        'unique_visitors', 'bounce_rate', 'avg_session_duration',
        'mobile_visitors', 'desktop_visitors', 'tablet_visitors',
        'referrer_data', 'country_data', 'browser_data'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
