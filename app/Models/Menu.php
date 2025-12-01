<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasTranslations, HasSlug;

    protected $fillable = ['name', 'slug', 'location', 'description', 'max_depth', 'is_active'];
    protected $casts = ['name' => 'array', 'is_active' => 'boolean', 'max_depth' => 'integer'];
    protected $translatable = ['name'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('order');
    }
}
