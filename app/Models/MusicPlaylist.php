<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicPlaylist extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id', 'song_title', 'song_path', 'artist',
        'album', 'duration', 'file_size', 'file_type',
        'volume', 'auto_play', 'loop_mode', 'play_order',
        'play_count', 'is_active'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
