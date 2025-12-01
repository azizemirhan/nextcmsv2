<?php

namespace App\Repositories;

use App\Models\Page;
use App\Repositories\Contracts\PageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PageRepository implements PageRepositoryInterface
{
    /**
     * Get all pages
     */
    public function all(): Collection
    {
        return Page::with(['sections', 'featuredImage'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get paginated pages
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Page::with(['sections', 'featuredImage'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Find page by ID
     */
    public function find(int $id): ?Page
    {
        return Page::with(['sections', 'featuredImage', 'seoMeta'])
            ->find($id);
    }

    /**
     * Find page by UUID
     */
    public function findByUuid(string $uuid): ?Page
    {
        return Page::with(['sections', 'featuredImage', 'seoMeta'])
            ->where('uuid', $uuid)
            ->first();
    }

    /**
     * Find page by slug
     */
    public function findBySlug(string $slug): ?Page
    {
        return Page::with(['sections' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }, 'featuredImage', 'seoMeta'])
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Get published pages
     */
    public function getPublished(): Collection
    {
        return Page::published()
            ->with(['sections', 'featuredImage'])
            ->orderBy('published_at', 'desc')
            ->get();
    }

    /**
     * Get pages by template
     */
    public function getByTemplate(string $template): Collection
    {
        return Page::template($template)
            ->with(['sections', 'featuredImage'])
            ->get();
    }

    /**
     * Create a new page
     */
    public function create(array $data): Page
    {
        return Page::create($data);
    }

    /**
     * Update a page
     */
    public function update(Page $page, array $data): bool
    {
        return $page->update($data);
    }

    /**
     * Delete a page
     */
    public function delete(Page $page): bool
    {
        return $page->delete();
    }

    /**
     * Search pages
     */
    public function search(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return Page::where(function ($q) use ($query) {
                $q->where('slug', 'like', "%{$query}%")
                    ->orWhereRaw("JSON_EXTRACT(title, '$.tr') LIKE ?", ["%{$query}%"])
                    ->orWhereRaw("JSON_EXTRACT(title, '$.en') LIKE ?", ["%{$query}%"]);
            })
            ->with(['sections', 'featuredImage'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get child pages
     */
    public function getChildren(int $parentId): Collection
    {
        return Page::where('parent_id', $parentId)
            ->orderBy('order')
            ->get();
    }
}
