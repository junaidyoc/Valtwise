<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaleEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaleEventController extends Controller
{
    /**
     * Display a listing of sale events.
     */
    public function index(Request $request)
    {
        $query = SaleEvent::query();

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('event_date', $request->year);
        } else {
            $query->whereYear('event_date', date('Y'));
        }

        // Filter by region
        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $events = $query->orderBy('event_date', 'asc')->paginate(20);

        // Get years for filter
        $years = SaleEvent::selectRaw('YEAR(event_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.sale-events.index', compact('events', 'years'));
    }

    /**
     * Show the form for creating a new sale event.
     */
    public function create()
    {
        return view('admin.sale-events.create');
    }

    /**
     * Store a newly created sale event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'emoji' => 'nullable|string|max:10',
            'subtitle_tags' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:event_date',
            'region' => 'required|in:uk,pk,global',
            'description' => 'nullable|string',
            'categories' => 'nullable|string|max:255',
            'density' => 'required|in:low,medium,high,peak',
            'sort_order' => 'nullable|integer',
            // SEO Fields
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'focus_keyword' => 'nullable|string|max:50',
            'og_title' => 'nullable|string|max:90',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|url|max:500',
            'canonical_url' => 'nullable|url|max:500',
            'robots_index' => 'nullable|in:index,noindex',
            'robots_follow' => 'nullable|in:follow,nofollow',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sitemap_include'] = $request->boolean('sitemap_include', true);

        // Handle checklist
        if ($request->filled('checklist')) {
            $validated['checklist'] = array_filter(array_map('trim', explode("\n", $request->checklist)));
        }

        // Handle event table
        if ($request->filled('event_table_data')) {
            $validated['event_table'] = json_decode($request->event_table_data, true);
        }

        SaleEvent::create($validated);

        return redirect()->route('admin.sale-events.index')
            ->with('success', 'Sale event created successfully!');
    }

    /**
     * Show the form for editing a sale event.
     */
    public function edit(SaleEvent $saleEvent)
    {
        return view('admin.sale-events.edit', compact('saleEvent'));
    }

    /**
     * Update the specified sale event.
     */
    public function update(Request $request, SaleEvent $saleEvent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'emoji' => 'nullable|string|max:10',
            'subtitle_tags' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:event_date',
            'region' => 'required|in:uk,pk,global',
            'description' => 'nullable|string',
            'categories' => 'nullable|string|max:255',
            'density' => 'required|in:low,medium,high,peak',
            'sort_order' => 'nullable|integer',
            // SEO Fields
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'focus_keyword' => 'nullable|string|max:50',
            'og_title' => 'nullable|string|max:90',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|url|max:500',
            'canonical_url' => 'nullable|url|max:500',
            'robots_index' => 'nullable|in:index,noindex',
            'robots_follow' => 'nullable|in:follow,nofollow',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sitemap_include'] = $request->boolean('sitemap_include', true);

        // Handle checklist
        if ($request->filled('checklist')) {
            $validated['checklist'] = array_filter(array_map('trim', explode("\n", $request->checklist)));
        } else {
            $validated['checklist'] = null;
        }

        // Handle event table
        if ($request->filled('event_table_data')) {
            $validated['event_table'] = json_decode($request->event_table_data, true);
        } else {
            $validated['event_table'] = null;
        }

        $saleEvent->update($validated);

        return redirect()->route('admin.sale-events.index')
            ->with('success', 'Sale event updated successfully!');
    }

    /**
     * Toggle event active status.
     */
    public function toggle(SaleEvent $saleEvent)
    {
        $saleEvent->update(['is_active' => !$saleEvent->is_active]);

        return back()->with('success', 'Event status updated!');
    }

    /**
     * Remove the specified sale event.
     */
    public function destroy(SaleEvent $saleEvent)
    {
        $saleEvent->delete();

        return redirect()->route('admin.sale-events.index')
            ->with('success', 'Sale event deleted successfully!');
    }
}
