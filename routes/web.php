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
use App\Http\Controllers\SearchController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommunityController;

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
use App\Http\Controllers\Admin\AdminAuthController;
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
use App\Http\Controllers\Admin\CommunityController as AdminCommunityController;


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
| Google Login
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| GOOGLE OAUTH
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', [
    GoogleController::class,
    'redirect'
])->name('google.login');

Route::get('/auth/google/callback', [
    GoogleController::class,
    'callback'
])->name('google.callback');


/*
|--------------------------------------------------------------------------
| USER LOGOUT
|--------------------------------------------------------------------------
*/

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
| Jalur rahasia admin + OTP
|--------------------------------------------------------------------------
*/


// ---------------------------------------------------------
// LOGIN ADMIN
// ---------------------------------------------------------

Route::get(
    '/panel-adminbaca/login',
    [AdminAuthController::class, 'showLoginForm']
)->name('admin.login');

Route::post(
    '/panel-adminbaca/login',
    [AdminAuthController::class, 'login']
)->name('admin.login.submit');


// ---------------------------------------------------------
// OTP ADMIN
// ---------------------------------------------------------

Route::get(
    '/panel-adminbaca/verify-otp',
    [AdminAuthController::class, 'showOtpForm']
)->name('admin.otp');

Route::post(
    '/panel-adminbaca/verify-otp',
    [AdminAuthController::class, 'processOtp']
)->name('admin.otp.submit');


// ---------------------------------------------------------
// KONFIRMASI AKSES ADMIN
// ---------------------------------------------------------

Route::get(
    '/panel-adminbaca/confirm-access',
    [AdminAuthController::class, 'showConfirmForm']
)->name('admin.confirm');

Route::post(
    '/panel-adminbaca/confirm-access',
    [AdminAuthController::class, 'processConfirm']
)->name('admin.confirm.submit');


/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/


// ---------------------------------------------------------
// INFORMATION
// ---------------------------------------------------------

Route::get(
    '/information',
    [InformationController::class, 'index']
)->name('informasi');

Route::get(
    '/information/{information:slug}',
    [InformationController::class, 'show']
)->name('informasi.show');


// ---------------------------------------------------------
// ARTICLES
// ---------------------------------------------------------

Route::get(
    '/articles',
    [DataArticleController::class, 'index']
)->name('articles');


// ---------------------------------------------------------
// JURNAL
// ---------------------------------------------------------

Route::get(
    '/jurnal',
    [JurnalController::class, 'index']
)->name('jurnal');


// ---------------------------------------------------------
// CONFERENCE
// ---------------------------------------------------------

Route::get(
    '/conference',
    [ConferenceController::class, 'index']
)->name('conference');


// ---------------------------------------------------------
// PUBLISHER
// ---------------------------------------------------------

Route::get(
    '/publisher',
    [PublisherController::class, 'index']
)->name('publisher');


// ---------------------------------------------------------
// KONSULTASI
// ---------------------------------------------------------

Route::get('/konsultasi', function () {

    return view('landing-page.pages.konsultasi');

})->name('konsultasi');


// ---------------------------------------------------------
// HAKI
// ---------------------------------------------------------

Route::get(
    '/haki',
    [HakiController::class, 'index']
)->name('haki.index');

Route::get('/haki/daftar/{jenis}', function ($jenis) {

    return view(
        'landing-page.pages.haki',
        ['jenis' => $jenis]
    );

})->name('haki.daftar');


// ---------------------------------------------------------
// CEK RESI
// ---------------------------------------------------------

Route::get(
    '/cek-resi',
    [ShipmentController::class, 'index']
)->name('cek-resi');

Route::post(
    '/cek-resi',
    [ShipmentController::class, 'track']
)->name('cek-resi.track');


// ---------------------------------------------------------
// TENTANG
// ---------------------------------------------------------

Route::get(
    '/tentang/dewan-redaksi',
    function () {
        return view('landing-page.pages.dewan-redaksi');
    }
)->name('tentang.dewan-redaksi');

Route::get(
    '/tentang/visi-misi',
    function () {
        return view('landing-page.pages.visi-misi');
    }
)->name('tentang.visi-misi');

Route::get(
    '/tentang/kontak',
    function () {
        return view('landing-page.pages.kontak');
    }
)->name('tentang.kontak');


// ---------------------------------------------------------
// PORTOFOLIO
// ---------------------------------------------------------

Route::get(
    '/portofolio/katalog',
    function () {
        return view('landing-page.pages.katalog-lengkap');
    }
)->name('portofolio.katalog');


// ---------------------------------------------------------
// BOOKSTORE
// ---------------------------------------------------------

Route::get(
    '/portofolio/bookstore',
    function () {

        $books = Book::latest()->get();

        return view(
            'landing-page.pages.bookstore',
            compact('books')
        );

    }
)->name('portofolio.bookstore');


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
*/


Route::get(
    '/blog',
    [BlogController::class, 'index']
)->name('blog.index');


Route::middleware('auth')->group(function () {

    // CREATE
    Route::get(
        '/blog/create',
        [BlogController::class, 'create']
    )->name('blog.create');


    // STORE
    Route::post(
        '/blog',
        [BlogController::class, 'store']
    )->name('blog.store');


    // MY POSTS
    Route::get(
        '/blog/saya',
        [BlogController::class, 'myPosts']
    )->name('blog.myPosts');


    // EDIT
    Route::get(
        '/blog/{post:slug}/edit',
        [BlogController::class, 'edit']
    )->name('blog.edit');


    // UPDATE
    Route::put(
        '/blog/{post:slug}',
        [BlogController::class, 'update']
    )->name('blog.update');


    // DELETE
    Route::delete(
        '/blog/{post:slug}',
        [BlogController::class, 'destroy']
    )->name('blog.destroy');


    // COMMENT
    Route::post(
        '/blog/{post}/comments',
        [CommentController::class, 'store']
    )->name('post.comment.store');
});


// SHOW BLOG
Route::get(
    '/blog/{post:slug}',
    [BlogController::class, 'show']
)->name('blog.show');


/*
|--------------------------------------------------------------------------
| COMMUNITY
|--------------------------------------------------------------------------
*/


Route::get(
    '/komunitas',
    [CommunityController::class, 'index']
)->name('community.index');


Route::middleware('auth')->group(function () {

    // CREATE COMMUNITY
    Route::get(
        '/komunitas/buat',
        [CommunityController::class, 'create']
    )->name('community.create');


    // STORE COMMUNITY
    Route::post(
        '/komunitas',
        [CommunityController::class, 'store']
    )->name('community.store');


    // JOIN
    Route::post(
        '/komunitas/{community}/join',
        [CommunityController::class, 'join']
    )->name('community.join');


    // LEAVE
    Route::post(
        '/komunitas/{community}/leave',
        [CommunityController::class, 'leave']
    )->name('community.leave');
});


// SHOW COMMUNITY
Route::get(
    '/komunitas/{community}',
    [CommunityController::class, 'show']
)->name('community.show');


/*
|--------------------------------------------------------------------------
| EVENT PUBLIC
|--------------------------------------------------------------------------
*/

Route::get(
    '/event',
    [EventController::class, 'index']
)->name('event.index');

Route::get(
    '/event/{slug}',
    [EventController::class, 'show']
)->name('event.show');


/*
|--------------------------------------------------------------------------
| TEAM
|--------------------------------------------------------------------------
*/

Route::get(
    '/team/{slug}',
    [TeamController::class, 'show']
)->name('team.show');


/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

Route::get(
    '/search',
    [SearchController::class, 'index']
)->name('search');


/*
|--------------------------------------------------------------------------
| LANGUAGE
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', function ($locale) {

    if (in_array($locale, [
        'id',
        'en',
        'zh',
        'ja',
        'ko'
    ])) {

        Session::put('locale', $locale);

        App::setLocale($locale);
    }

    return redirect()->back();

})->name('language');


/*
|--------------------------------------------------------------------------
| ADMIN CMS
|--------------------------------------------------------------------------
| Semua halaman di bawah ini membutuhkan:
|
| 1. auth
| 2. admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:admin', 'admin'])


->prefix('admin')
->name('admin.')
->group(function () {


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | BOOKS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'books',
        AdminBookController::class
    )->scoped([
        'book' => 'slug'
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
    | POST APPROVAL
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/posts/{post}/approve',
        [PostController::class, 'approve']
    )->name('posts.approve');

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
    | COMMUNITIES
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'communities',
        AdminCommunityController::class
    );


    /*
    |--------------------------------------------------------------------------
    | COMMUNITY APPROVAL
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/communities/{community}/approve',
        [AdminCommunityController::class, 'approve']
    )->name('communities.approve');

    Route::post(
        '/communities/{community}/reject',
        [AdminCommunityController::class, 'reject']
    )->name('communities.reject');


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