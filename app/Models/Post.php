<?php

namespace App\Models;

use App\Traits\HasMedia;
use App\Traits\HasSeo;
use App\Traits\HasSlug;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes, HasTranslations, HasMedia, HasSeo, HasSlug;

    protected $fillable = ['uuid', 'slug', 'title', 'excerpt', 'content', 'featured_image_id', 'status', 'type', 'visibility', 'password', 'author_id', 'published_at', 'scheduled_at', 'expired_at', 'reading_time', 'view_count', 'is_featured', 'is_sticky', 'allow_comments', 'created_by', 'updated_by'];
    protected $casts = ['title' => 'array', 'excerpt' => 'array', 'content' => 'array', 'published_at' => 'datetime', 'scheduled_at' => 'datetime', 'expired_at' => 'datetime', 'is_featured' => 'boolean', 'is_sticky' => 'boolean', 'allow_comments' => 'boolean', 'view_count' => 'integer', 'reading_time' => 'integer'];
    protected $translatable = ['title', 'excerpt', 'content'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($post) => $post->uuid = $post->uuid ?? (string) Str::uuid());
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category')->withPivot('is_primary');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where(fn($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getUrl(?string $locale = null): string
    {
        return url(($locale ?? app()->getLocale()) . '/blog/' . $this->slug);
    }
}
