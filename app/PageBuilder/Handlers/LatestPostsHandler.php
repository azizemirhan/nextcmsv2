<?php

namespace App\PageBuilder\Handlers;

use App\Models\PageSection;
use App\Models\Post;
use App\PageBuilder\Contracts\SectionHandlerInterface;

class LatestPostsHandler implements SectionHandlerInterface
{
    /**
     * Handle section data
     */
    public function handle(array $content, PageSection $section): array
    {
        $limit = $content['limit'] ?? 3;
        $category = $content['category'] ?? null;

        $query = Post::published()
            ->with(['featuredImage', 'categories'])
            ->orderBy('published_at', 'desc')
            ->limit($limit);

        if ($category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $posts = $query->get();

        // Add posts to content
        $content['posts'] = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'excerpt' => $post->excerpt,
                'slug' => $post->slug,
                'url' => $post->getUrl(),
                'image' => $post->featuredImage?->path,
                'published_at' => $post->published_at->format('d M Y'),
                'categories' => $post->categories->pluck('name', 'slug'),
            ];
        })->toArray();

        return $content;
    }
}
