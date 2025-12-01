<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaUsage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'media_id',
        'usable_type',
        'usable_id',
        'field_name',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function usable()
    {
        return $this->morphTo();
    }
}
