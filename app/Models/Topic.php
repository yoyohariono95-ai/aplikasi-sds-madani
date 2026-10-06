<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected $casts = [
        'micro_steps' => 'array',
    ];

    protected $appends = ['embed_url'];

    public function getEmbedUrlAttribute()
    {
        return self::parseYoutubeUrl($this->video_url);
    }

    public static function parseYoutubeUrl($url)
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // Standard YouTube URL formats:
        // https://www.youtube.com/watch?v=VIDEO_ID
        // https://youtu.be/VIDEO_ID
        // https://www.youtube.com/embed/VIDEO_ID
        // https://m.youtube.com/watch?v=VIDEO_ID
        // https://www.youtube.com/shorts/VIDEO_ID
        if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            return 'https://www.youtube-nocookie.com/embed/' . $matches[1] . '?rel=0&modestbranding=1';
        }

        // If directly provided an 11-character video ID
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return 'https://www.youtube-nocookie.com/embed/' . $url . '?rel=0&modestbranding=1';
        }

        return $url;
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'topic_id');
    }
}
