<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $featured = Event::where('is_featured', true)
            ->orderByDesc('start_date')
            ->first();

        $events = Event::orderByDesc('start_date')
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->paginate(9);

        return view('landing-page.pages.event', compact('featured', 'events'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        return view('landing-page.pages.event-detail', compact('event'));
    }
}