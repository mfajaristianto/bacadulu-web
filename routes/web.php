<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\DataArticleController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\HakiController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TeamController;

Route::get('/cek-resi', [ShipmentController::class, 'index'])->name('cek-resi');
Route::post('/cek-resi', [ShipmentController::class, 'track'])->name('cek-resi.track');

Route::get('/haki', [HakiController::class, 'index'])->name('haki.index');

// --- KATALOG BACA ROUTES ---
Route::get('/information', [InformationController::class, 'index'])->name('informasi');

Route::get('/articles', [DataArticleController::class, 'index'])->name('articles');

// Jika konsultasi belum ada controllernya, bisa diarahkan langsung ke view:
Route::get('/konsultasi', function () {
    return view('landing-page.pages.konsultasi');
})->name('konsultasi');

Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal');

Route::get('/conference', [ConferenceController::class, 'index'])->name('conference');

Route::get('/publisher', [PublisherController::class, 'index'])->name('publisher');


// 1. Halaman Utama (Home)
Route::get('/', function () {
    if (session()->has('locale')) {
        App::setLocale(session()->get('locale'));
    }
    return view('landing-page.index');
})->name('home');

// 2. Tentang Kami (Halaman Terpisah)
Route::get('/tentang/dewan-redaksi', function () { 
    return view('landing-page.pages.dewan-redaksi'); 
})->name('tentang.dewan-redaksi');

Route::get('/tentang/visi-misi', function () { 
    return view('landing-page.pages.visi-misi'); 
})->name('tentang.visi-misi');

Route::get('/tentang/kontak', function () { 
    return view('landing-page.pages.kontak'); 
})->name('tentang.kontak');


// 3. Portofolio (Halaman Terpisah)
Route::get('/portofolio/katalog', function () { 
    return view('landing-page.pages.katalog-lengkap'); 
})->name('portofolio.katalog');

Route::get('/portofolio/bookstore', function () { 
    return view('landing-page.pages.bookstore'); 
})->name('portofolio.bookstore');


// 4. HAKI (Halaman Terpisah berdasarkan jenis)
Route::get('/haki/daftar/{jenis}', function ($jenis) { 
    return view('landing-page.pages.haki', ['jenis' => $jenis]); 
})->name('haki.daftar');


// 5. Cek Resi (Halaman Terpisah)
Route::get('/cek-resi', function () { 
    return view('landing-page.pages.cek-resi'); 
})->name('cek-resi');


// 6. Detail Biografi Tim
Route::get('/team/{slug}', [TeamController::class, 'show'])->name('team.show');


// Action Ganti Bahasa
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en', 'zh', 'ja', 'ko'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }

    return redirect()->back();
});