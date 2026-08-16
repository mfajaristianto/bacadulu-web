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
| USER AUTHENTICATION (Google Login)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN AUTHENTICATION (Jalur Rahasia & Berlapis OTP)
|--------------------------------------------------------------------------
*/

// 1. Form Login Awal (Email & Password)
Route::get('/panel-adminbaca/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/panel-adminbaca/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// 2. Form Verifikasi Kode OTP (Dikirim ke email pusat)
Route::get('/panel-adminbaca/verify-otp', [AdminAuthController::class, 'showOtpForm'])->name('admin.otp');
Route::post('/panel-adminbaca/verify-otp', [AdminAuthController::class, 'processOtp'])->name('admin.otp.submit');

// 3. Form Konfirmasi Final (Ketik ulang email & password)
Route::get('/panel-adminbaca/confirm-access', [AdminAuthController::class, 'showConfirmForm'])->name('admin.confirm');
Route::post('/panel-adminbaca/confirm-access', [AdminAuthController::class, 'processConfirm'])->name('admin.confirm.submit');


/*
|--------------------------------------------------------------------------
| PUBLIC PAGES (Informasi, Artikel, Jurnal, dll)
|--------------------------------------------------------------------------
*/
Route::get('/information', [InformationController::class, 'index'])->name('informasi');
Route::get('/articles', [DataArticleController::class, 'index'])->name('articles');
Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal');
Route::get('/conference', [ConferenceController::class, 'index'])->name('conference');
Route::get('/publisher', [PublisherController::class, 'index'])->name('publisher');

Route::get('/konsultasi', function () {
    return view('landing-page.pages.konsultasi');
})->name('konsultasi');

Route::get('/haki', [HakiController::class, 'index'])->name('haki.index');
Route::get('/haki/daftar/{jenis}', function ($jenis) {
    return view('landing-page.pages.haki', ['jenis' => $jenis]);
})->name('haki.daftar');

Route::get('/cek-resi', [ShipmentController::class, 'index'])->name('cek-resi');
Route::post('/cek-resi', [ShipmentController::class, 'track'])->name('cek-resi.track');

Route::get('/tentang/dewan-redaksi', function () { return view('landing-page.pages.dewan-redaksi'); })->name('tentang.dewan-redaksi');
Route::get('/tentang/visi-misi', function () { return view('landing-page.pages.visi-misi'); })->name('tentang.visi-misi');
Route::get('/tentang/kontak', function () { return view('landing-page.pages.kontak'); })->name('tentang.kontak');

Route::get('/portofolio/katalog', function () {
    return view('landing-page.pages.katalog-lengkap');
})->name('portofolio.katalog');

Route::get('/portofolio/bookstore', function () {
    $books = Book::latest()->get();
    return view('landing-page.pages.bookstore', compact('books'));
})->name('portofolio.bookstore');

Route::get('/portofolio/bookstore/{book:slug}', function (Book $book) {
    return view('landing-page.pages.book-detail', compact('book'));
})->name('portofolio.bookstore.show');


/*
|--------------------------------------------------------------------------
| BLOG & USER ACTIONS
|--------------------------------------------------------------------------
*/
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

Route::middleware('auth')->group(function () {
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/saya', [BlogController::class, 'myPosts'])->name('blog.myPosts');
    Route::get('/blog/{post:slug}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post:slug}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post:slug}', [BlogController::class, 'destroy'])->name('blog.destroy');
    Route::post('/blog/{post}/comments', [CommentController::class, 'store'])->name('post.comment.store');
});

Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');


/*
|--------------------------------------------------------------------------
| EVENT PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.show');


/*
|--------------------------------------------------------------------------
| USER PROFILE & TEAM & SEARCH & LANGUAGE
|--------------------------------------------------------------------------
*/
Route::get('/user/{id}', [ProfileController::class, 'show'])->name('user.profile');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/team/{slug}', [TeamController::class, 'show'])->name('team.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en', 'zh', 'ja', 'ko'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('language');


/*
|--------------------------------------------------------------------------
| ADMIN CMS ROUTES (Dilindungi Middleware Auth & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('books', AdminBookController::class)->scoped(['book' => 'slug']);
        Route::resource('informations', InformationAdminController::class);
        Route::resource('journals', JurnalAdminController::class);
        Route::resource('conferences', ConferenceAdminController::class);
        Route::resource('publishers', PublisherAdminController::class);
        Route::resource('data-articles', DataArticleAdminController::class);
        Route::resource('posts', PostController::class);

        Route::post('/posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
        Route::post('/posts/{post}/reject', [PostController::class, 'reject'])->name('posts.reject');

        Route::resource('events', EventAdminController::class);

        Route::get('/detail/{type}/{id}', [DetailController::class, 'show'])->name('detail.show');
        
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });