<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Book;

// =====================================================
// PUBLIC CONTROLLER IMPORTS
// =====================================================
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\DataArticleController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\HakiController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\EventController;

// =====================================================
// ADMIN CONTROLLER IMPORTS
// =====================================================
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InformationAdminController;
use App\Http\Controllers\Admin\JurnalAdminController;
use App\Http\Controllers\Admin\ConferenceAdminController;
use App\Http\Controllers\Admin\PublisherAdminController;
use App\Http\Controllers\Admin\DataArticleAdminController;
use App\Http\Controllers\Admin\DetailController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\EventAdminController;


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('admin.login.post');

Route::post('/login-process', [AuthController::class, 'login'])
    ->name('login.post');


// Logout Global untuk User/Navbar Publik
Route::post('/logout', function () {
    auth()->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// =====================================================
// HOME
// =====================================================

Route::get('/', function () {

    if (session()->has('locale')) {
        App::setLocale(session()->get('locale'));
    }

    return view('landing-page.index');

})->name('home');


// =====================================================
// INFORMASI
// =====================================================

Route::get('/information', [InformationController::class, 'index'])
    ->name('informasi');


// =====================================================
// ARTICLES
// =====================================================

Route::get('/articles', [DataArticleController::class, 'index'])
    ->name('articles');


// =====================================================
// JURNAL
// =====================================================

Route::get('/jurnal', [JurnalController::class, 'index'])
    ->name('jurnal');


// =====================================================
// CONFERENCE
// =====================================================

Route::get('/conference', [ConferenceController::class, 'index'])
    ->name('conference');


// =====================================================
// PUBLISHER
// =====================================================

Route::get('/publisher', [PublisherController::class, 'index'])
    ->name('publisher');


// =====================================================
// KONSULTASI
// =====================================================

Route::get('/konsultasi', function () {
    return view('landing-page.pages.konsultasi');
})->name('konsultasi');


// =====================================================
// HAKI
// =====================================================

Route::get('/haki', [HakiController::class, 'index'])
    ->name('haki.index');

Route::get('/haki/daftar/{jenis}', function ($jenis) {

    return view('landing-page.pages.haki', [
        'jenis' => $jenis
    ]);

})->name('haki.daftar');


// =====================================================
// CEK RESI
// =====================================================

Route::get('/cek-resi', [ShipmentController::class, 'index'])
    ->name('cek-resi');

Route::post('/cek-resi', [ShipmentController::class, 'track'])
    ->name('cek-resi.track');


// =====================================================
// TENTANG KAMI
// =====================================================

Route::get('/tentang/dewan-redaksi', function () {
    return view('landing-page.pages.dewan-redaksi');
})->name('tentang.dewan-redaksi');

Route::get('/tentang/visi-misi', function () {
    return view('landing-page.pages.visi-misi');
})->name('tentang.visi-misi');

Route::get('/tentang/kontak', function () {
    return view('landing-page.pages.kontak');
})->name('tentang.kontak');


// =====================================================
// PORTOFOLIO & BOOKSTORE
// =====================================================

Route::get('/portofolio/katalog', function () {
    return view('landing-page.pages.katalog-lengkap');
})->name('portofolio.katalog');


Route::get('/portofolio/bookstore', function () {

    $books = Book::latest()->get();

    return view(
        'landing-page.pages.bookstore',
        compact('books')
    );

})->name('portofolio.bookstore');


// Detail buku menggunakan slug
Route::get('/portofolio/bookstore/{book:slug}', function (Book $book) {

    return view(
        'landing-page.pages.book-detail',
        compact('book')
    );

})->name('portofolio.bookstore.show');


// =====================================================
// BLOG & COMMENTS - PUBLIC
// =====================================================

Route::get('/blog', [BlogController::class, 'index'])
    ->name('blog.index');

Route::get('/blog/create', [BlogController::class, 'create'])
    ->middleware('auth')
    ->name('blog.create');

Route::post('/blog', [BlogController::class, 'store'])
    ->middleware('auth')
    ->name('blog.store');

Route::get('/blog/{post:slug}/edit', [BlogController::class, 'edit'])
    ->middleware('auth')
    ->name('blog.edit');

Route::put('/blog/{post:slug}', [BlogController::class, 'update'])
    ->middleware('auth')
    ->name('blog.update');

Route::delete('/blog/{post:slug}', [BlogController::class, 'destroy'])
    ->middleware('auth')
    ->name('blog.destroy');

Route::post('/blog/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('post.comment.store');

Route::get('/blog/{post:slug}', [BlogController::class, 'show'])
    ->name('blog.show');


// =====================================================
// EVENT - PUBLIC
// =====================================================

// Halaman daftar Event
Route::get('/event', [EventController::class, 'index'])
    ->name('event.index');

// Detail Event
Route::get('/event/{slug}', [EventController::class, 'show'])
    ->name('event.show');


// =====================================================
// PROFILE, TEAM & SEARCH
// =====================================================

Route::get('/user/{id}', [ProfileController::class, 'show'])
    ->name('user.profile');

Route::get('/profile/edit', [ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('profile.edit');

Route::put('/profile/update', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

Route::get('/team/{slug}', [TeamController::class, 'show'])
    ->name('team.show');

Route::get('/search', [SearchController::class, 'index'])
    ->name('search');


// =====================================================
// GANTI BAHASA
// =====================================================

Route::get('/lang/{locale}', function ($locale) {

    if (in_array($locale, ['id', 'en', 'zh', 'ja', 'ko'])) {

        Session::put('locale', $locale);
        App::setLocale($locale);
    }

    return redirect()->back();

});


/*
|--------------------------------------------------------------------------
| ADMIN CMS ROUTES
|--------------------------------------------------------------------------
|
| Semua route di bawah /admin membutuhkan login.
|
*/

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // =====================================================
        // DASHBOARD
        // =====================================================

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');


        // =====================================================
        // LOGOUT ADMIN
        // =====================================================

        Route::match(['get', 'post'], '/logout', function () {

            auth()->logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect('/');

        })->name('logout');


        // =====================================================
        // ADMIN CRUD
        // =====================================================

        // Buku
        Route::resource(
            'books',
            AdminBookController::class
        )->scoped([
            'book' => 'id'
        ]);


        // Informasi
        Route::resource(
            'informations',
            InformationAdminController::class
        );


        // Jurnal
        Route::resource(
            'journals',
            JurnalAdminController::class
        );


        // Konferensi
        Route::resource(
            'conferences',
            ConferenceAdminController::class
        );


        // Publisher
        Route::resource(
            'publishers',
            PublisherAdminController::class
        );


        // Data Articles
        Route::resource(
            'data-articles',
            DataArticleAdminController::class
        );


        // Artikel / Blog yang dikelola Admin
        Route::resource(
            'posts',
            PostController::class
        );


        // =====================================================
        // EVENT ADMIN
        // =====================================================

        Route::resource(
            'events',
            EventAdminController::class
        );


        // =====================================================
        // DETAIL HELPER
        // =====================================================

        Route::get(
            '/detail/{type}/{id}',
            [DetailController::class, 'show']
        )->name('detail.show');

    });