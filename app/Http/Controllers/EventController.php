<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $featured = Event::where(
                'is_featured',
                true
            )
            ->orderByDesc('start_date')
            ->first();


        $events = Event::query()
            ->orderByDesc('start_date')
            ->when(
                $featured,
                function ($query) use ($featured) {

                    $query->where(
                        'id',
                        '!=',
                        $featured->id
                    );
                }
            )
            ->paginate(9)
            ->withQueryString();


        return view(
            'event.index',
            compact(
                'featured',
                'events'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($slug)
    {
        $event = Event::where(
                'slug',
                $slug
            )
            ->firstOrFail();


        return view(
            'event.show',
            compact('event')
        );
    }
}