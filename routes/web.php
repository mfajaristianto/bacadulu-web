<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| PUBLIC CONTROLLERS
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| USER AUTH
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

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
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (session()->has('locale')) {
        App::setLocale(session()->get('locale'));
    }

    return view('landing-page.index');

})->name('home');


/*
|--------------------------------------------------------------------------
| USER AUTHENTICATION
|--------------------------------------------------------------------------
|
| Google Login hanya untuk USER / PENULIS.
|
*/


// Halaman login user
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


// Redirect ke Google
Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');


// Callback Google
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');


// Logout user
Route::post('/logout', function () {

    auth()->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');

})->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN AUTHENTICATION
|--------------------------------------------------------------------------
|
| Login admin terpisah.
|
*/


// Halaman login admin
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])
    ->name('admin.login');


// Proses login admin
Route::post('/admin/login', [AuthController::class, 'login'])
    ->name('admin.login.post');


// Logout admin
Route::post('/admin/logout', [AuthController::class, 'logout'])
    ->middleware(['auth', 'admin'])
    ->name('admin.logout');


/*
|--------------------------------------------------------------------------
| INFORMASI
|--------------------------------------------------------------------------
*/

Route::get('/information', [InformationController::class, 'index'])
    ->name('informasi');


/*
|--------------------------------------------------------------------------
| ARTICLES
|--------------------------------------------------------------------------
*/

Route::get('/articles', [DataArticleController::class, 'index'])
    ->name('articles');


/*
|--------------------------------------------------------------------------
| JURNAL
|--------------------------------------------------------------------------
*/

Route::get('/jurnal', [JurnalController::class, 'index'])
    ->name('jurnal');


/*
|--------------------------------------------------------------------------
| CONFERENCE
|--------------------------------------------------------------------------
*/

Route::get('/conference', [ConferenceController::class, 'index'])
    ->name('conference');


/*
|--------------------------------------------------------------------------
| PUBLISHER
|--------------------------------------------------------------------------
*/

Route::get('/publisher', [PublisherController::class, 'index'])
    ->name('publisher');


/*
|--------------------------------------------------------------------------
| KONSULTASI
|--------------------------------------------------------------------------
*/

Route::get('/konsultasi', function () {

    return view('landing-page.pages.konsultasi');

})->name('konsultasi');


/*
|--------------------------------------------------------------------------
| HAKI
|--------------------------------------------------------------------------
*/

Route::get('/haki', [HakiController::class, 'index'])
    ->name('haki.index');


Route::get('/haki/daftar/{jenis}', function ($jenis) {

    return view('landing-page.pages.haki', [
        'jenis' => $jenis
    ]);

})->name('haki.daftar');


/*
|--------------------------------------------------------------------------
| CEK RESI
|--------------------------------------------------------------------------
*/

Route::get('/cek-resi', [ShipmentController::class, 'index'])
    ->name('cek-resi');


Route::post('/cek-resi', [ShipmentController::class, 'track'])
    ->name('cek-resi.track');


/*
|--------------------------------------------------------------------------
| TENTANG KAMI
|--------------------------------------------------------------------------
*/

Route::get('/tentang/dewan-redaksi', function () {

    return view('landing-page.pages.dewan-redaksi');

})->name('tentang.dewan-redaksi');


Route::get('/tentang/visi-misi', function () {

    return view('landing-page.pages.visi-misi');

})->name('tentang.visi-misi');


Route::get('/tentang/kontak', function () {

    return view('landing-page.pages.kontak');

})->name('tentang.kontak');


/*
|--------------------------------------------------------------------------
| PORTOFOLIO
|--------------------------------------------------------------------------
*/

Route::get('/portofolio/katalog', function () {

    return view('landing-page.pages.katalog-lengkap');

})->name('portofolio.katalog');


/*
|--------------------------------------------------------------------------
| BOOKSTORE
|--------------------------------------------------------------------------
*/

Route::get('/portofolio/bookstore', function () {

    $books = Book::latest()->get();

    return view(
        'landing-page.pages.bookstore',
        compact('books')
    );

})->name('portofolio.bookstore');


/*
|--------------------------------------------------------------------------
| BOOK DETAIL
|--------------------------------------------------------------------------
*/

Route::get(
    '/portofolio/bookstore/{book:slug}',
    function (Book $book) {

        return view(
            'landing-page.pages.book-detail',
            compact('book')
        );

    }
)->name('portofolio.bookstore.show');


/*
|--------------------------------------------------------------------------
| BLOG
|--------------------------------------------------------------------------
|
| BLOG PUBLIC
| Semua orang bisa membaca artikel.
|
| BLOG USER
| User yang sudah login bisa:
| - Menulis artikel
| - Melihat artikel sendiri
| - Edit artikel sendiri
| - Hapus artikel sendiri
| - Memberikan komentar
|
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| BLOG - PUBLIC
|--------------------------------------------------------------------------
*/


// Daftar semua artikel yang sudah approved
Route::get('/blog', [BlogController::class, 'index'])
    ->name('blog.index');


/*
|--------------------------------------------------------------------------
| BLOG - USER / PENULIS
|--------------------------------------------------------------------------
|
| Semua route di bawah ini membutuhkan login.
|
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | CREATE ARTICLE
    |--------------------------------------------------------------------------
    |
    | URL:
    | /blog/create
    |
    */

    Route::get('/blog/create', [BlogController::class, 'create'])
        ->name('blog.create');


    /*
    |--------------------------------------------------------------------------
    | STORE ARTICLE
    |--------------------------------------------------------------------------
    |
    | URL:
    | POST /blog
    |
    */

    Route::post('/blog', [BlogController::class, 'store'])
        ->name('blog.store');


    /*
    |--------------------------------------------------------------------------
    | MY POSTS
    |--------------------------------------------------------------------------
    |
    | URL:
    | /blog/saya
    |
    */

    Route::get('/blog/saya', [BlogController::class, 'myPosts'])
        ->name('blog.myPosts');


    /*
    |--------------------------------------------------------------------------
    | EDIT ARTICLE
    |--------------------------------------------------------------------------
    |
    | URL:
    | /blog/{post}/edit
    |
    */

    Route::get(
        '/blog/{post:slug}/edit',
        [BlogController::class, 'edit']
    )->name('blog.edit');


    /*
    |--------------------------------------------------------------------------
    | UPDATE ARTICLE
    |--------------------------------------------------------------------------
    |
    | URL:
    | PUT /blog/{post}
    |
    */

    Route::put(
        '/blog/{post:slug}',
        [BlogController::class, 'update']
    )->name('blog.update');


    /*
    |--------------------------------------------------------------------------
    | DELETE ARTICLE
    |--------------------------------------------------------------------------
    |
    | URL:
    | DELETE /blog/{post}
    |
    */

    Route::delete(
        '/blog/{post:slug}',
        [BlogController::class, 'destroy']
    )->name('blog.destroy');


    /*
    |--------------------------------------------------------------------------
    | COMMENT
    |--------------------------------------------------------------------------
    |
    | User yang login dapat memberikan komentar.
    |
    */

    Route::post(
        '/blog/{post}/comments',
        [CommentController::class, 'store']
    )->name('post.comment.store');

});


/*
|--------------------------------------------------------------------------
| BLOG - DETAIL PUBLIC
|--------------------------------------------------------------------------
|
| PENTING:
| Route wildcard {post:slug} diletakkan SETELAH
| /blog/create dan /blog/saya.
|
|--------------------------------------------------------------------------
*/


Route::get('/blog/{post:slug}', [BlogController::class, 'show'])
    ->name('blog.show');


/*
|--------------------------------------------------------------------------
| EVENT PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/event', [EventController::class, 'index'])
    ->name('event.index');


Route::get('/event/{slug}', [EventController::class, 'show'])
    ->name('event.show');


/*
|--------------------------------------------------------------------------
| USER PROFILE
|--------------------------------------------------------------------------
*/


// Profile public
Route::get('/user/{id}', [ProfileController::class, 'show'])
    ->name('user.profile');


// Profile user login
Route::middleware('auth')->group(function () {

    Route::get(
        '/profile/edit',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::put(
        '/profile/update',
        [ProfileController::class, 'update']
    )->name('profile.update');

});


/*
|--------------------------------------------------------------------------
| TEAM
|--------------------------------------------------------------------------
*/

Route::get('/team/{slug}', [TeamController::class, 'show'])
    ->name('team.show');


/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

Route::get('/search', [SearchController::class, 'index'])
    ->name('search');


/*
|--------------------------------------------------------------------------
| LANGUAGE
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', function ($locale) {

    if (in_array($locale, ['id', 'en', 'zh', 'ja', 'ko'])) {

        Session::put('locale', $locale);

        App::setLocale($locale);
    }

    return redirect()->back();

})->name('language');


/*
|--------------------------------------------------------------------------
| ADMIN CMS
|--------------------------------------------------------------------------
|
| auth  = harus login
| admin = harus is_admin = true
|
| User Google biasa TIDAK bisa masuk.
|
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | BOOKS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'books',
            AdminBookController::class
        )->scoped([
            'book' => 'id'
        ]);


        /*
        |--------------------------------------------------------------------------
        | INFORMATIONS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'informations',
            InformationAdminController::class
        );


        /*
        |--------------------------------------------------------------------------
        | JOURNALS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'journals',
            JurnalAdminController::class
        );


        /*
        |--------------------------------------------------------------------------
        | CONFERENCES
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'conferences',
            ConferenceAdminController::class
        );


        /*
        |--------------------------------------------------------------------------
        | PUBLISHERS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'publishers',
            PublisherAdminController::class
        );


        /*
        |--------------------------------------------------------------------------
        | DATA ARTICLES
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'data-articles',
            DataArticleAdminController::class
        );


        /*
        |--------------------------------------------------------------------------
        | BLOG POSTS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'posts',
            PostController::class
        );


        /*
        |--------------------------------------------------------------------------
        | APPROVE ARTICLE
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/posts/{post}/approve',
            [PostController::class, 'approve']
        )->name('posts.approve');


        /*
        |--------------------------------------------------------------------------
        | REJECT ARTICLE
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/posts/{post}/reject',
            [PostController::class, 'reject']
        )->name('posts.reject');


        /*
        |--------------------------------------------------------------------------
        | EVENTS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'events',
            EventAdminController::class
        );


        /*
        |--------------------------------------------------------------------------
        | DETAIL
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/detail/{type}/{id}',
            [DetailController::class, 'show']
        )->name('detail.show');


        /*
        |--------------------------------------------------------------------------
        | ADMIN LOGOUT
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/logout',
            [AuthController::class, 'logout']
        )->name('logout');

    });