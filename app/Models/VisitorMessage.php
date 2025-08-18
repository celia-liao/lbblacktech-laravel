<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id', 'visitor_name', 'visitor_email', 'visitor_relation',
        'message_content', 'message_type', 'is_approved', 'is_public',
        'ip_address', 'user_agent', 'reply_content', 'reply_date'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
