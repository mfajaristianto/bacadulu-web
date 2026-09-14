<?php

namespace App\Http\Controllers;

use App\Models\Information;

class InformationController extends Controller
{
    public function index()
    {
        $pinnedInformation = Information::query()
            ->where('is_pinned', true)
            ->orderByDesc('pinned_at')
            ->orderByRaw('COALESCE(published_at, DATE(created_at)) DESC')
            ->orderByDesc('created_at')
            ->first();

        $latestInformations = Information::query()
            ->when(
                $pinnedInformation,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $pinnedInformation->id
                )
            )
            ->orderByRaw('COALESCE(published_at, DATE(created_at)) DESC')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        $excludedIds = $latestInformations
            ->pluck('id')
            ->values();

        if ($pinnedInformation) {
            $excludedIds->push($pinnedInformation->id);
        }

        $allInformations = Information::query()
            ->when(
                $excludedIds->isNotEmpty(),
                fn ($query) => $query->whereNotIn(
                    'id',
                    $excludedIds
                )
            )
            ->orderByRaw('COALESCE(published_at, DATE(created_at)) DESC')
            ->orderByDesc('created_at')
            ->get();

        $totalInformations = Information::count();

        $lastInformation = Information::query()
            ->orderByRaw('COALESCE(published_at, DATE(created_at)) DESC')
            ->orderByDesc('created_at')
            ->first([
                'published_at',
                'created_at',
            ]);

        $lastUpdate = $lastInformation?->published_at
            ?? $lastInformation?->created_at;

        return view(
            'landing-page.pages.information',
            compact(
                'pinnedInformation',
                'latestInformations',
                'allInformations',
                'totalInformations',
                'lastUpdate'
            )
        );
    }

    public function show(Information $information)
    {
        return view(
            'landing-page.pages.information-detail',
            compact('information')
        );
    }
}
