<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $page = Page::where('slug', $slug)
            ->published()
            ->with(['sections' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->firstOrFail();

        // Increment view count
        $page->incrementViewCount();

        return view('frontend.layouts.app', compact('page'));
    }

    public function home()
    {
        $page = Page::where('slug', 'home')
            ->orWhere('template', 'home')
            ->published()
            ->with(['sections' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->firstOrFail();

        return view('frontend.layouts.app', compact('page'));
    }
}
