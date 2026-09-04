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
            ->latest()
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
            ->latest()
            ->get();

        $totalInformations = Information::count();

        $lastUpdate = Information::query()
            ->latest('created_at')
            ->value('created_at');

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