<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PageSection extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'page_id',
        'section_key',
        'content',
        'order',
        'is_active',
        'copied_from_id',
        'visibility',
        'custom_css',
        'custom_class',
        'cache_ttl',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'content' => 'array',
        'visibility' => 'array',
        'order' => 'integer',
        'is_active' => 'boolean',
        'cache_ttl' => 'integer',
    ];

    protected $translatable = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($section) {
            if (empty($section->uuid)) {
                $section->uuid = (string) Str::uuid();
            }
        });
    }

    // --- Relationships ---

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(SectionTemplate::class, 'section_key', 'key');
    }

    public function copiedFrom(): BelongsTo
    {
        return $this->belongsTo(PageSection::class, 'copied_from_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // --- Helper Methods ---

    public function render(): string
    {
        $template = $this->template;
        
        if (!$template || !$template->view_path) {
            return '';
        }

        return view($template->view_path, [
            'section' => $this,
            'content' => $this->content,
        ])->render();
    }

    public function isVisible(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $visibility = $this->visibility ?? [];

        // Check device
        if (isset($visibility['devices'])) {
            $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone/', request()->header('User-Agent'));
           $currentDevice = $isMobile ? 'mobile' : 'desktop';
            
            if (!in_array($currentDevice, $visibility['devices'])) {
                return false;
            }
        }

        // Check schedule
        if (isset($visibility['start_date']) && now()->lt($visibility['start_date'])) {
            return false;
        }

        if (isset($visibility['end_date']) && now()->gt($visibility['end_date'])) {
            return false;
        }

        // Check roles (if user authenticated)
        if (isset($visibility['roles']) && auth()->check()) {
            if (!auth()->user()->hasAnyRole($visibility['roles'])) {
                return false;
            }
        }

        return true;
    }
}
