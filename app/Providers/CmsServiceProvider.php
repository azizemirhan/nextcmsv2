<?php

namespace App\Providers;

use App\PageBuilder\Contracts\SectionRendererInterface;
use App\PageBuilder\SectionRenderer;
use App\PageBuilder\SectionRegistry;
use App\Repositories\Contracts\PageRepositoryInterface;
use App\Repositories\PageRepository;
use App\Services\Page\PageCacheService;
use App\Services\Page\PageService;
use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register repositories
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);

        // Register services
        $this->app->singleton(PageCacheService::class);
        $this->app->singleton(PageService::class);

        // Register page builder services
        $this->app->bind(SectionRendererInterface::class, SectionRenderer::class);
        $this->app->singleton(SectionRenderer::class);
        $this->app->singleton(SectionRegistry::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Optionally sync sections from config on boot (only in local environment)
        if (config('app.env') === 'local') {
            try {
                $registry = $this->app->make(SectionRegistry::class);
                // Uncomment to auto-sync sections from config
                // $registry->syncFromConfig();
            } catch (\Exception $e) {
                // Silently fail during migrations
            }
        }
    }
}
