<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Book;

// Public Controller Imports
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

// Admin Controller Imports (Menggunakan alias AdminBookController untuk menghindari bentrok nama)
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InformationAdminController;
use App\Http\Controllers\Admin\JurnalAdminController;
use App\Http\Controllers\Admin\ConferenceAdminController;
use App\Http\Controllers\Admin\PublisherAdminController;
use App\Http\Controllers\Admin\DataArticleAdminController;
use App\Http\Controllers\Admin\DetailController;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Global Login & Logout)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');

// Route Logout Global untuk User/Navbar Publik
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

Route::get('/', function () {
    if (session()->has('locale')) {
        App::setLocale(session()->get('locale'));
    }
    return view('landing-page.index');
})->name('home');

Route::get('/information', [InformationController::class, 'index'])->name('informasi');
Route::get('/articles', [DataArticleController::class, 'index'])->name('articles');
Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal');
Route::get('/conference', [ConferenceController::class, 'index'])->name('conference');
Route::get('/publisher', [PublisherController::class, 'index'])->name('publisher');

Route::get('/konsultasi', function () {
    return view('landing-page.pages.konsultasi');
})->name('konsultasi');

// HAKI
Route::get('/haki', [HakiController::class, 'index'])->name('haki.index');
Route::get('/haki/daftar/{jenis}', function ($jenis) { 
    return view('landing-page.pages.haki', ['jenis' => $jenis]); 
})->name('haki.daftar');

// Cek Resi
Route::get('/cek-resi', [ShipmentController::class, 'index'])->name('cek-resi');
Route::post('/cek-resi', [ShipmentController::class, 'track'])->name('cek-resi.track');

// Tentang Kami
Route::get('/tentang/dewan-redaksi', function () { return view('landing-page.pages.dewan-redaksi'); })->name('tentang.dewan-redaksi');
Route::get('/tentang/visi-misi', function () { return view('landing-page.pages.visi-misi'); })->name('tentang.visi-misi');
Route::get('/tentang/kontak', function () { return view('landing-page.pages.kontak'); })->name('tentang.kontak');

// Portofolio & Bookstore (Publik)
Route::get('/portofolio/katalog', function () { return view('landing-page.pages.katalog-lengkap'); })->name('portofolio.katalog');
Route::get('/portofolio/bookstore', function () { 
    $books = Book::latest()->get();
    return view('landing-page.pages.bookstore', compact('books'));
})->name('portofolio.bookstore');
Route::get('/portofolio/bookstore/{book}', function (Book $book) {
    return view('landing-page.pages.book-detail', compact('book'));
})->name('portofolio.bookstore.show');

// Blog & Comments (Publik)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/create', [BlogController::class, 'create'])->middleware('auth')->name('blog.create');
Route::post('/blog', [BlogController::class, 'store'])->middleware('auth')->name('blog.store');
Route::get('/blog/{post:slug}/edit', [BlogController::class, 'edit'])->middleware('auth')->name('blog.edit');
Route::put('/blog/{post:slug}', [BlogController::class, 'update'])->middleware('auth')->name('blog.update');
Route::delete('/blog/{post:slug}', [BlogController::class, 'destroy'])->middleware('auth')->name('blog.destroy');
Route::post('/blog/{post}/comments', [CommentController::class, 'store'])->middleware('auth')->name('post.comment.store');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// Profil, Tim, & Search
Route::get('/user/{id}', [ProfileController::class, 'show'])->name('user.profile');
Route::get('/team/{slug}', [TeamController::class, 'show'])->name('team.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Ganti Bahasa
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en', 'zh', 'ja', 'ko'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
});


/*
|--------------------------------------------------------------------------
| Admin CMS Routes (Prefix: /admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route Logout Khusus Admin (Menghasilkan nama route 'admin.logout')
    Route::match(['get', 'post'], '/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
    
    // CRUD Resources (Menggunakan AdminBookController)
    Route::resource('books', AdminBookController::class);
    Route::resource('informations', InformationAdminController::class);
    Route::resource('journals', JurnalAdminController::class);
    Route::resource('conferences', ConferenceAdminController::class);
    Route::resource('publishers', PublisherAdminController::class);
    Route::resource('data-articles', DataArticleAdminController::class);

    // Detail Helper
    Route::get('/detail/{type}/{id}', [DetailController::class, 'show'])->name('detail.show');

    // ... (Bagian route lainnya tetap sama)

// Profil, Tim, & Search (Tambahkan route edit)
Route::get('/user/{id}', [ProfileController::class, 'show'])->name('user.profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');

Route::get('/team/{slug}', [TeamController::class, 'show'])->name('team.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Blog & Comments (Publik & Protected)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/create', [BlogController::class, 'create'])->middleware('auth')->name('blog.create');
Route::post('/blog', [BlogController::class, 'store'])->middleware('auth')->name('blog.store');
Route::get('/blog/{post:slug}/edit', [BlogController::class, 'edit'])->middleware('auth')->name('blog.edit');
Route::put('/blog/{post:slug}', [BlogController::class, 'update'])->middleware('auth')->name('blog.update');
Route::delete('/blog/{post:slug}', [BlogController::class, 'destroy'])->middleware('auth')->name('blog.destroy');
Route::post('/blog/{post}/comments', [CommentController::class, 'store'])->middleware('auth')->name('post.comment.store');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// ... (Sisa route lainnya)
});