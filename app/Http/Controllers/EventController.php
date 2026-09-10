<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $featured = Event::query()
            ->where('is_featured', true)
            ->orderByDesc('start_date')
            ->first();

        $events = Event::query()
            ->when(
                $featured,
                fn ($query) => $query->whereKeyNot($featured->id)
            )
            ->orderByDesc('start_date')
            ->paginate(9)
            ->withQueryString();

        $latestEvents = Event::query()
            ->when(
                $featured,
                fn ($query) => $query->whereKeyNot($featured->id)
            )
            ->orderByDesc('start_date')
            ->limit(5)
            ->get();

        return view(
            'event.index',
            compact(
                'featured',
                'events',
                'latestEvents'
            )
        );
    }

    public function show(string $slug)
    {
        $event = Event::query()
            ->where('slug', $slug)
            ->firstOrFail();

        return view(
            'event.show',
            compact('event')
        );
    }
}
