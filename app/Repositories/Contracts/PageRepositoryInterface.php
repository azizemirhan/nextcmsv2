<?php

namespace App\Repositories\Contracts;

use App\Models\Page;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PageRepositoryInterface
{
    /**
     * Get all pages
     */
    public function all(): Collection;

    /**
     * Get paginated pages
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Find page by ID
     */
    public function find(int $id): ?Page;

    /**
     * Find page by UUID
     */
    public function findByUuid(string $uuid): ?Page;

    /**
     * Find page by slug
     */
    public function findBySlug(string $slug): ?Page;

    /**
     * Get published pages
     */
    public function getPublished(): Collection;

    /**
     * Get pages by template
     */
    public function getByTemplate(string $template): Collection;

    /**
     * Create a new page
     */
    public function create(array $data): Page;

    /**
     * Update a page
     */
    public function update(Page $page, array $data): bool;

    /**
     * Delete a page
     */
    public function delete(Page $page): bool;

    /**
     * Search pages
     */
    public function search(string $query, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get child pages
     */
    public function getChildren(int $parentId): Collection;
}
