<?php

namespace App\Models;

use App\Traits\HasMedia;
use App\Traits\HasSeo;
use App\Traits\HasSlug;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Page extends Model
{
    use SoftDeletes, HasTranslations, HasMedia, HasSeo, HasSlug;

    protected $fillable = [
        'uuid',
        'parent_id',
        'slug',
        'template',
        'status',
        'title',
        'excerpt',
        'banner_title',
        'banner_subtitle',
        'banner_image_id',
        'banner_enabled',
        'banner_background_image',
        'banner_background_color',
        'banner_overlay_opacity',
        'banner_text_color',
        'banner_height',
        'banner_text_align',
        'featured_image_id',
        'published_at',
        'scheduled_at',
        'expired_at',
        'password',
        'view_count',
        'order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'title' => 'array',
        'excerpt' => 'array',
        'banner_title' => 'array',
        'banner_subtitle' => 'array',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'expired_at' => 'datetime',
        'view_count' => 'integer',
        'order' => 'integer',
    ];

    protected $translatable = ['title', 'excerpt', 'banner_title', 'banner_subtitle'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->uuid)) {
                $page->uuid = (string) Str::uuid();
            }
        });
    }

    // --- Relationships ---

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('order');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('order');
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(PageRevision::class)->orderByDesc('revision_number');
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // --- Scopes ---

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            });
    }

    public function scopeTemplate($query, string $template)
    {
        return $query->where('template', $template);
    }

    // --- Helper Methods ---

    public function isPublished(): bool
    {
        return $this->status === 'published' 
            && ($this->published_at === null || $this->published_at->isPast())
            && ($this->expired_at === null || $this->expired_at->isFuture());
    }

    public function isProtected(): bool
    {
        return !empty($this->password);
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    /**
     * Get full URL
     */
    public function getUrl(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        return url("/{$locale}/{$this->slug}");
    }

    /**
     * Create revision snapshot
     */
    public function createRevision(): void
    {
        $latestRevision = $this->revisions()->first();
        $nextNumber = $latestRevision ? $latestRevision->revision_number + 1 : 1;

        PageRevision::create([
            'page_id' => $this->id,
            'revision_number' => $nextNumber,
            'title' => $this->title,
            'sections_snapshot' => $this->sections->toArray(),
            'created_by' => auth()->id(),
        ]);
    }
}
