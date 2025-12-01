<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaConversion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'media_id',
        'conversion_name',
        'path',
        'disk',
        'filename',
        'width',
        'height',
        'size_bytes',
        'format',
        'quality',
    ];

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'size_bytes' => 'integer',
        'quality' => 'integer',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
