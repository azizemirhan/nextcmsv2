<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Media extends Model
{
    use SoftDeletes, HasTranslations;

    protected $fillable = [
        'uuid',
        'storage_profile_id',
        'folder_id',
        'filename',
        'original_filename',
        'path',
        'disk',
        'extension',
        'mime_type',
        'type',
        'size_bytes',
        'width',
        'height',
        'duration',
        'checksum_sha256',
        'title',
        'alt',
        'caption',
        'description',
        'dominant_color',
        'focal_point',
        'exif_data',
        'is_private',
        'download_count',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'title' => 'array',
        'alt' => 'array',
        'caption' => 'array',
        'description' => 'array',
        'focal_point' => 'array',
        'exif_data' => 'array',
        'is_private' => 'boolean',
        'download_count' => 'integer',
        'size_bytes' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'duration' => 'integer',
    ];

    protected $translatable = ['title', 'alt', 'caption', 'description'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($media) {
            if (empty($media->uuid)) {
                $media->uuid = (string) Str::uuid();
            }
        });
    }

    // --- Relationships ---

    public function storageProfile(): BelongsTo
    {
        return $this->belongsTo(StorageProfile::class);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(MediaFolder::class, 'folder_id');
    }

    public function conversions(): HasMany
    {
        return $this->hasMany(MediaConversion::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // --- Helper Methods ---

    public function getUrl(): string
    {
        if ($this->is_private) {
            return route('media.serve', ['uuid' => $this->uuid]);
        }

        return Storage::disk($this->disk)->url($this->path);
    }

    public function getConversionVersion(string $name): ?MediaConversion
    {
        return $this->conversions()->where('conversion_name', $name)->first();
    }

    public function getConversionUrl(string $name): ?string
    {
        $conversion = $this->getConversionVersion($name);
        
        if (!$conversion) {
            return $this->getUrl(); // Fallback to original
        }

        return Storage::disk($conversion->disk)->url($conversion->path);
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function getHumanSize(): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->size_bytes;
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
    }

    /**
     * Get responsive srcset for images
     */
    public function getSrcset(): string
    {
        if (!$this->isImage()) {
            return '';
        }

        $srcset = [];
        
        foreach (['thumb', 'medium', 'large'] as $size) {
            $conversion = $this->getConversionVersion($size);
            if ($conversion) {
                $srcset[] = $this->getConversionUrl($size) . ' ' . $conversion->width . 'w';
            }
        }

        return implode(', ', $srcset);
    }
}
