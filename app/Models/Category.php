<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasTranslations, HasSlug;

    protected $fillable = ['parent_id', 'slug', 'name', 'description', 'image_id', 'color', 'icon', 'order', 'is_active'];
    protected $casts = ['name' => 'array', 'description' => 'array', 'is_active'  => 'boolean', 'order' => 'integer'];
    protected $translatable = ['name', 'description'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
