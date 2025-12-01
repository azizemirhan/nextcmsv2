<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageRevision extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'page_id',
        'revision_number',
        'title',
        'sections_snapshot',
        'created_by',
        'created_at',
    ];

    protected $casts = [
        'title' => 'array',
        'sections_snapshot' => 'array',
        'created_at' => 'datetime',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Restore this revision to the page
     */
    public function restore(): void
    {
        $this->page->update([
            'title' => $this->title,
        ]);

        // Delete current sections
        $this->page->sections()->delete();

        // Restore sections from snapshot
        foreach ($this->sections_snapshot as $sectionData) {
            unset($sectionData['id'], $sectionData['created_at'], $sectionData['updated_at']);
            $this->page->sections()->create($sectionData);
        }
    }
}
