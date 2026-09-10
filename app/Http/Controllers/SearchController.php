<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Community;
use App\Models\Conference;
use App\Models\Event;
use App\Models\Information;
use App\Models\Jurnal;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ], [
            'q.max' => 'Kata kunci pencarian maksimal 100 karakter.',
        ]);

        $query = trim((string) ($validated['q'] ?? ''));

        $informations = collect();
        $journals = collect();
        $conferences = collect();
        $books = collect();
        $posts = collect();
        $events = collect();
        $communities = collect();

        if ($query !== '') {
            $like = $this->likePattern($query);

            $informations = Information::query()
                ->where(function ($builder) use ($like) {
                    $builder
                        ->where('title', 'like', $like)
                        ->orWhere('content', 'like', $like);
                })
                ->latest()
                ->limit(6)
                ->get();

            $journals = Jurnal::query()
                ->where(function ($builder) use ($like) {
                    $builder
                        ->where('judul', 'like', $like)
                        ->orWhere('deskripsi', 'like', $like)
                        ->orWhere('e_issn', 'like', $like)
                        ->orWhere('p_issn', 'like', $like);
                })
                ->latest()
                ->limit(6)
                ->get();

            $conferences = Conference::query()
                ->where(function ($builder) use ($like) {
                    $builder
                        ->where('name', 'like', $like)
                        ->orWhere('edition', 'like', $like)
                        ->orWhere('description', 'like', $like);
                })
                ->latest()
                ->limit(6)
                ->get();

            $books = Book::query()
                ->where(function ($builder) use ($like) {
                    $builder
                        ->where('title', 'like', $like)
                        ->orWhere('author', 'like', $like)
                        ->orWhere('publisher', 'like', $like)
                        ->orWhere('category', 'like', $like)
                        ->orWhere('description', 'like', $like)
                        ->orWhere('isbn', 'like', $like)
                        ->orWhere('print_isbn', 'like', $like)
                        ->orWhere('ebook_isbn', 'like', $like);
                })
                ->latest()
                ->limit(6)
                ->get();

            $posts = Post::query()
                ->where('status', 'approved')
                ->where(function ($builder) use ($like) {
                    $builder
                        ->where('title', 'like', $like)
                        ->orWhere('author', 'like', $like)
                        ->orWhere('category', 'like', $like)
                        ->orWhere('content', 'like', $like);
                })
                ->latest()
                ->limit(6)
                ->get();

            $events = Event::query()
                ->where(function ($builder) use ($like) {
                    $builder
                        ->where('title', 'like', $like)
                        ->orWhere('category', 'like', $like)
                        ->orWhere('location', 'like', $like)
                        ->orWhere('description', 'like', $like);
                })
                ->orderByDesc('start_date')
                ->limit(6)
                ->get();

            $communities = Community::query()
                ->approved()
                ->where(function ($builder) use ($like) {
                    $builder
                        ->where('name', 'like', $like)
                        ->orWhere('description', 'like', $like);
                })
                ->latest()
                ->limit(6)
                ->get();
        }

        $totalResults = $this->totalResults([
            $informations,
            $journals,
            $conferences,
            $books,
            $posts,
            $events,
            $communities,
        ]);

        return view('search.index', compact(
            'query',
            'informations',
            'journals',
            'conferences',
            'books',
            'posts',
            'events',
            'communities',
            'totalResults'
        ));
    }

    private function likePattern(string $query): string
    {
        $escaped = str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\\%', '\\_'],
            $query
        );

        return "%{$escaped}%";
    }

    private function totalResults(array $collections): int
    {
        return collect($collections)
            ->filter(fn ($items) => $items instanceof Collection)
            ->sum(fn (Collection $items) => $items->count());
    }
}
