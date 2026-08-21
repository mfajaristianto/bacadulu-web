<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\DataArticle;
use App\Models\Information;
use App\Models\Jurnal;
use App\Models\Publisher;
use App\Models\Post;
use App\Models\Community;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK ARTIKEL
        |--------------------------------------------------------------------------
        */

        $totalPosts = Post::count();

        $pendingPosts = Post::where('status', 'pending')->count();

        $approvedPosts = Post::where('status', 'approved')->count();

        $rejectedPosts = Post::where('status', 'rejected')->count();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK KONTEN WEBSITE
        |--------------------------------------------------------------------------
        */

        $stats = [

            // Artikel
            'posts' => $totalPosts,
            'pending_posts' => $pendingPosts,
            'approved_posts' => $approvedPosts,
            'rejected_posts' => $rejectedPosts,

            // Konten Website
            'informations' => Information::count(),
            'journals' => Jurnal::count(),
            'conferences' => Conference::count(),
            'publishers' => Publisher::count(),
            'data_articles' => DataArticle::count(),

            // Komunitas
            'communities' => Community::count(),

            // Event
            'events' => class_exists(\App\Models\Event::class)
                ? \App\Models\Event::count()
                : 0,

            // Buku
            'books' => class_exists(\App\Models\Book::class)
                ? \App\Models\Book::count()
                : 0,
        ];


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact('stats'));
    }
}