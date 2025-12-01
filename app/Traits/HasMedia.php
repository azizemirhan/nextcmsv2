<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMedia
{
    /**
     * Get all media for this model (polymorphic)
     */
    public function media(): MorphMany
    {
        return $this->morphMany(
            \App\Models\Media::class,
            'usable',
            'usable_type',
            'usable_id'
        )->orderBy('order');
    }

    /**
     * Get the first media item
     */
    public function getFirstMedia(?string $collection = null): ?\App\Models\Media
    {
        $query = $this->media();
        
        if ($collection) {
            $query->where('collection_name', $collection);
        }

        return $query->first();
    }

    /**
     * Get media URL for a specific conversion
     */
    public function getMediaUrl(string $conversion = 'original', ?string $collection = null): ?string
    {
        $media = $this->getFirstMedia($collection);

        if (!$media) {
            return null;
        }

        if ($conversion === 'original') {
            return $media->getUrl();
        }

        return $media->getConversionUrl($conversion);
    }

    /**
     * Get responsive picture data (for <x-picture> component)
     */
    public function getResponsivePicture(?string $collection = null): ?array
    {
        $media = $this->getFirstMedia($collection);

        if (!$media) {
            return null;
        }

        return [
            'original' => $media->getUrl(),
            'webp' => $media->getConversionUrl('webp'),
            'thumb' => $media->getConversionUrl('thumb'),
            'medium' => $media->getConversionUrl('medium'),
            'large' => $media->getConversionUrl('large'),
            'alt' => $media->getTranslation('alt'),
            'title' => $media->getTranslation('title'),
        ];
    }

    /**
     * Attach media to this model
     */
    public function attachMedia(int $mediaId, ?string $collection = null): void
    {
        $media = \App\Models\Media::find($mediaId);
        
        if ($media) {
            \App\Models\MediaUsage::create([
                'media_id' => $mediaId,
                'usable_type' => get_class($this),
                'usable_id' => $this->id,
                'field_name' => $collection,
            ]);
        }
    }

    /**
     * Detach media from this model
     */
    public function detachMedia(int $mediaId): void
    {
        \App\Models\MediaUsage::where([
            'media_id' => $mediaId,
            'usable_type' => get_class($this),
            'usable_id' => $this->id,
        ])->delete();
    }

    /**
     * Sync media (replace all with new set)
     */
    public function syncMedia(array $mediaIds, ?string $collection = null): void
    {
        // Remove old
        \App\Models\MediaUsage::where([
            'usable_type' => get_class($this),
            'usable_id' => $this->id,
            'field_name' => $collection,
        ])->delete();

        // Add new
        foreach ($mediaIds as $order => $mediaId) {
            \App\Models\MediaUsage::create([
                'media_id' => $mediaId,
                'usable_type' => get_class($this),
                'usable_id' => $this->id,
                'field_name' => $collection,
                'order' => $order,
            ]);
        }
    }
}
