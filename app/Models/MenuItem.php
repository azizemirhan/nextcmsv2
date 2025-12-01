<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasTranslations;

    protected $fillable = ['menu_id', 'parent_id', 'title', 'type', 'linkable_type', 'linkable_id', 'url', 'route_name', 'route_params', 'target', 'rel', 'icon', 'image_id', 'css_class', 'is_mega_menu', 'mega_columns', 'mega_content', 'highlight_type', 'highlight_text', 'order', 'is_active'];
    protected $casts = ['title' => 'array', 'route_params' => 'array', 'mega_content' => 'array', 'highlight_text' => 'array', 'is_mega_menu' => 'boolean', 'is_active' => 'boolean', 'order' => 'integer'];
    protected $translatable = ['title'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function linkable()
    {
        return $this->morphTo();
    }

    public function getLink(): string
    {
        return match ($this->type) {
            'url' => $this->url,
            'route' => route($this->route_name, $this->route_params ?? []),
            'page', 'post', 'category' => $this->linkable?->getUrl() ?? '#',
            default => '#',
        };
    }
}
