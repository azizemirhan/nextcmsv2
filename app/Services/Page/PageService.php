<?php

namespace App\Services\Page;

use App\Models\Page;
use App\Repositories\PageRepository;
use App\Events\PagePublished;
use App\Events\PageUnpublished;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PageService
{
    public function __construct(
        protected PageRepository $repository,
        protected PageCacheService $cacheService
    ) {}

    /**
     * Create a new page
     */
    public function create(array $data): Page
    {
        try {
            DB::beginTransaction();

            // Generate UUID if not provided
            if (empty($data['uuid'])) {
                $data['uuid'] = (string) Str::uuid();
            }

            // Auto-generate slug if not provided
            if (empty($data['slug']) && !empty($data['title'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title']);
            }

            // Set created_by
            if (auth()->check() && empty($data['created_by'])) {
                $data['created_by'] = auth()->id();
            }

            $page = $this->repository->create($data);

            DB::commit();

            // Clear cache
            $this->cacheService->clearPageCache($page);

            Log::info('Page created', ['page_id' => $page->id, 'slug' => $page->slug]);

            return $page;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Page creation failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Update a page
     */
    public function update(Page $page, array $data): bool
    {
        try {
            DB::beginTransaction();

            $oldStatus = $page->status;

            // Set updated_by
            if (auth()->check()) {
                $data['updated_by'] = auth()->id();
            }

            // Update slug if title changed
            if (!empty($data['title']) && $data['title'] !== $page->title && empty($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $page->id);
            }

            $result = $this->repository->update($page, $data);

            DB::commit();

            // Clear cache
            $this->cacheService->clearPageCache($page);

            // Fire events if status changed
            $newStatus = $data['status'] ?? $page->status;
            if ($oldStatus !== $newStatus) {
                if ($newStatus === 'published') {
                    event(new PagePublished($page));
                } elseif ($oldStatus === 'published') {
                    event(new PageUnpublished($page));
                }
            }

            Log::info('Page updated', ['page_id' => $page->id]);

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Page update failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Delete a page
     */
    public function delete(Page $page): bool
    {
        try {
            // Clear cache before deletion
            $this->cacheService->clearPageCache($page);

            $result = $this->repository->delete($page);

            Log::info('Page deleted', ['page_id' => $page->id]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Page deletion failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Publish a page
     */
    public function publish(Page $page): bool
    {
        $result = $this->update($page, [
            'status' => 'published',
            'published_at' => $page->published_at ?? now(),
        ]);

        if ($result) {
            event(new PagePublished($page->fresh()));
        }

        return $result;
    }

    /**
     * Unpublish a page
     */
    public function unpublish(Page $page): bool
    {
        $result = $this->update($page, [
            'status' => 'draft',
        ]);

        if ($result) {
            event(new PageUnpublished($page->fresh()));
        }

        return $result;
    }

    /**
     * Duplicate a page
     */
    public function duplicate(Page $page): Page
    {
        $newPage = $page->replicate();
        $newPage->uuid = (string) Str::uuid();
        $newPage->slug = $this->generateUniqueSlug($page->title);
        $newPage->status = 'draft';
        $newPage->published_at = null;
        $newPage->created_by = auth()->id();
        $newPage->save();

        // Duplicate sections
        foreach ($page->sections as $section) {
            $newSection = $section->replicate();
            $newSection->page_id = $newPage->id;
            $newSection->uuid = (string) Str::uuid();
            $newSection->copied_from_id = $section->id;
            $newSection->save();
        }

        Log::info('Page duplicated', [
            'original_id' => $page->id,
            'new_id' => $newPage->id
        ]);

        return $newPage;
    }

    /**
     * Create a revision for the page
     */
    public function createRevision(Page $page): void
    {
        $page->createRevision();
        Log::info('Page revision created', ['page_id' => $page->id]);
    }

    /**
     * Generate unique slug
     */
    protected function generateUniqueSlug($title, ?int $excludeId = null): string
    {
        // Get title in default locale
        $titleText = is_array($title)
            ? ($title[config('app.locale')] ?? $title[config('app.fallback_locale')] ?? reset($title))
            : $title;

        $slug = Str::slug($titleText);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if slug exists
     */
    protected function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = Page::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Get page with cache
     */
    public function getPageBySlug(string $slug): ?Page
    {
        return $this->cacheService->remember(
            "page.slug.{$slug}",
            3600,
            fn() => $this->repository->findBySlug($slug)
        );
    }
}
