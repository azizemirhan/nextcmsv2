<?php

namespace App\Providers;

use App\Models\Setting;
use App\Observers\SettingObserver;
use App\PageBuilder\Contracts\SectionRendererInterface;
use App\PageBuilder\SectionRenderer;
use App\PageBuilder\SectionRegistry;
use App\Repositories\Contracts\PageRepositoryInterface;
use App\Repositories\Contracts\SettingsRepositoryInterface;
use App\Repositories\PageRepository;
use App\Repositories\SettingsRepository;
use App\Services\Page\PageCacheService;
use App\Services\Page\PageService;
use App\Services\Settings\SettingsCacheService;
use App\Services\Settings\SettingsService;
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
        $this->app->bind(SettingsRepositoryInterface::class, SettingsRepository::class);

        // Register page services
        $this->app->singleton(PageCacheService::class);
        $this->app->singleton(PageService::class);

        // Register settings services
        $this->app->singleton(SettingsCacheService::class);
        $this->app->singleton(SettingsService::class);

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
        // Register observers
        Setting::observe(SettingObserver::class);

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
