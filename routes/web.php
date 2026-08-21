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

        App::setLocale(
            session()->get('locale')
        );
    }

    return view(
        'landing-page.index'
    );

})->name('home');


/*
|--------------------------------------------------------------------------
| USER LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {

    return view(
        'auth.login'
    );

})->name('login');


/*
|--------------------------------------------------------------------------
| GOOGLE LOGIN
|--------------------------------------------------------------------------
*/

Route::get(
    '/auth/google',
    [
        GoogleController::class,
        'redirect'
    ]
)->name('google.login');


Route::get(
    '/auth/google/callback',
    [
        GoogleController::class,
        'callback'
    ]
)->name('google.callback');


/*
|--------------------------------------------------------------------------
| USER LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {

    auth()->logout();

    request()
        ->session()
        ->invalidate();

    request()
        ->session()
        ->regenerateToken();

    return redirect()
        ->route('home');

})
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/

Route::get(
    '/panel-adminbaca/login',
    [
        AdminAuthController::class,
        'showLoginForm'
    ]
)->name('admin.login');


Route::post(
    '/panel-adminbaca/login',
    [
        AdminAuthController::class,
        'login'
    ]
)->name('admin.login.submit');


/*
|--------------------------------------------------------------------------
| ADMIN OTP
|--------------------------------------------------------------------------
*/

Route::get(
    '/panel-adminbaca/verify-otp',
    [
        AdminAuthController::class,
        'showOtpForm'
    ]
)->name('admin.otp');


Route::post(
    '/panel-adminbaca/verify-otp',
    [
        AdminAuthController::class,
        'processOtp'
    ]
)->name('admin.otp.submit');


/*
|--------------------------------------------------------------------------
| ADMIN CONFIRM ACCESS
|--------------------------------------------------------------------------
*/

Route::get(
    '/panel-adminbaca/confirm-access',
    [
        AdminAuthController::class,
        'showConfirmForm'
    ]
)->name('admin.confirm');


Route::post(
    '/panel-adminbaca/confirm-access',
    [
        AdminAuthController::class,
        'processConfirm'
    ]
)->name('admin.confirm.submit');


/*
|--------------------------------------------------------------------------
| INFORMATION
|--------------------------------------------------------------------------
*/

Route::get(
    '/information',
    [
        InformationController::class,
        'index'
    ]
)->name('informasi');


Route::get(
    '/information/{information:slug}',
    [
        InformationController::class,
        'show'
    ]
)->name('informasi.show');


/*
|--------------------------------------------------------------------------
| ARTICLES
|--------------------------------------------------------------------------
*/

Route::get(
    '/articles',
    [
        DataArticleController::class,
        'index'
    ]
)->name('articles');


/*
|--------------------------------------------------------------------------
| JURNAL
|--------------------------------------------------------------------------
*/

Route::get(
    '/jurnal',
    [
        JurnalController::class,
        'index'
    ]
)->name('jurnal');


/*
|--------------------------------------------------------------------------
| CONFERENCE
|--------------------------------------------------------------------------
*/

Route::get(
    '/conference',
    [
        ConferenceController::class,
        'index'
    ]
)->name('conference');


/*
|--------------------------------------------------------------------------
| PUBLISHER
|--------------------------------------------------------------------------
*/

Route::get(
    '/publisher',
    [
        PublisherController::class,
        'index'
    ]
)->name('publisher');


/*
|--------------------------------------------------------------------------
| KONSULTASI
|--------------------------------------------------------------------------
*/

Route::get('/konsultasi', function () {

    return view(
        'landing-page.pages.konsultasi'
    );

})->name('konsultasi');


/*
|--------------------------------------------------------------------------
| HAKI
|--------------------------------------------------------------------------
*/

Route::get(
    '/haki',
    [
        HakiController::class,
        'index'
    ]
)->name('haki.index');


Route::get('/haki/daftar/{jenis}', function ($jenis) {

    return view(
        'landing-page.pages.haki',
        [
            'jenis' => $jenis
        ]
    );

})->name('haki.daftar');


/*
|--------------------------------------------------------------------------
| CEK RESI
|--------------------------------------------------------------------------
*/

Route::get(
    '/cek-resi',
    [
        ShipmentController::class,
        'index'
    ]
)->name('cek-resi');


Route::post(
    '/cek-resi',
    [
        ShipmentController::class,
        'track'
    ]
)->name('cek-resi.track');


/*
|--------------------------------------------------------------------------
| TENTANG
|--------------------------------------------------------------------------
*/

Route::get(
    '/tentang/dewan-redaksi',
    function () {

        return view(
            'landing-page.pages.dewan-redaksi'
        );
    }
)->name('tentang.dewan-redaksi');


Route::get(
    '/tentang/visi-misi',
    function () {

        return view(
            'landing-page.pages.visi-misi'
        );
    }
)->name('tentang.visi-misi');


Route::get(
    '/tentang/kontak',
    function () {

        return view(
            'landing-page.pages.kontak'
        );
    }
)->name('tentang.kontak');


/*
|--------------------------------------------------------------------------
| PORTOFOLIO
|--------------------------------------------------------------------------
*/

Route::get(
    '/portofolio/katalog',
    function () {

        return view(
            'landing-page.pages.katalog-lengkap'
        );
    }
)->name('portofolio.katalog');


/*
|--------------------------------------------------------------------------
| BOOKSTORE
|--------------------------------------------------------------------------
*/

Route::get(
    '/portofolio/bookstore',
    function () {

        $books = Book::latest()
            ->get();

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
| BLOG PUBLIC
|--------------------------------------------------------------------------
*/

Route::get(
    '/blog',
    [
        BlogController::class,
        'index'
    ]
)->name('blog.index');


/*
|--------------------------------------------------------------------------
| BLOG USER / PENULIS
|--------------------------------------------------------------------------
|
| Semua route di bawah membutuhkan login user.
|
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | CREATE ARTICLE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/blog/create',
            [
                BlogController::class,
                'create'
            ]
        )->name('blog.create');


        /*
        |--------------------------------------------------------------------------
        | STORE ARTICLE
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/blog',
            [
                BlogController::class,
                'store'
            ]
        )->name('blog.store');


        /*
        |--------------------------------------------------------------------------
        | MY POSTS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/blog/saya',
            [
                BlogController::class,
                'myPosts'
            ]
        )->name('blog.myPosts');


        /*
        |--------------------------------------------------------------------------
        | EDIT ARTICLE
        |--------------------------------------------------------------------------
        |
        | Menggunakan slug.
        |
        | Contoh:
        |
        | /blog/test-artikel-123/edit
        |
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/blog/{post:slug}/edit',
            [
                BlogController::class,
                'edit'
            ]
        )->name('blog.edit');


        /*
        |--------------------------------------------------------------------------
        | UPDATE ARTICLE
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/blog/{post:slug}',
            [
                BlogController::class,
                'update'
            ]
        )->name('blog.update');


        /*
        |--------------------------------------------------------------------------
        | DELETE ARTICLE
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/blog/{post:slug}',
            [
                BlogController::class,
                'destroy'
            ]
        )->name('blog.destroy');


        /*
        |--------------------------------------------------------------------------
        | LIKE ARTICLE
        |--------------------------------------------------------------------------
        |
        | Sengaja tidak memakai :slug di parameter route.
        |
        | Karena controller toggleLike() gabungan kita dapat menerima:
        |
        | ID:
        | /blog/13/like
        |
        | atau slug:
        | /blog/test-artikel-123/like
        |
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/blog/{post}/like',
            [
                BlogController::class,
                'toggleLike'
            ]
        )->name('blog.like');


        /*
        |--------------------------------------------------------------------------
        | COMMENT ARTICLE
        |--------------------------------------------------------------------------
        |
        | Komentar menggunakan route model binding berdasarkan SLUG.
        |
        | Contoh:
        |
        | /blog/test-artikel-1-1787287056/comments
        |
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/blog/{post:slug}/comments',
            [
                CommentController::class,
                'store'
            ]
        )->name('post.comment.store');

    });


/*
|--------------------------------------------------------------------------
| SHOW BLOG ARTICLE
|--------------------------------------------------------------------------
|
| HARUS berada setelah:
|
| /blog/create
| /blog/saya
|
|--------------------------------------------------------------------------
*/

Route::get(
    '/blog/{post:slug}',
    [
        BlogController::class,
        'show'
    ]
)->name('blog.show');


/*
|--------------------------------------------------------------------------
| COMMUNITY PUBLIC
|--------------------------------------------------------------------------
|
| Halaman daftar komunitas dapat dilihat semua pengunjung.
|
|--------------------------------------------------------------------------
*/

Route::get(
    '/komunitas',
    [
        CommunityController::class,
        'index'
    ]
)->name('community.index');


/*
|--------------------------------------------------------------------------
| COMMUNITY USER
|--------------------------------------------------------------------------
|
| Semua route berikut hanya untuk USER yang login.
|
| USER:
|
| - Membuat komunitas
| - Edit komunitas miliknya sendiri
| - Update komunitas miliknya sendiri
| - Join komunitas
| - Leave komunitas
|
| ADMIN tetap menggunakan:
|
| /admin/communities/...
|
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | CREATE COMMUNITY
    |--------------------------------------------------------------------------
    |
    | GET /komunitas/buat
    |
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/komunitas/buat',
        [
            CommunityController::class,
            'create'
        ]
    )->name('community.create');


    /*
    |--------------------------------------------------------------------------
    | STORE COMMUNITY
    |--------------------------------------------------------------------------
    |
    | POST /komunitas
    |
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/komunitas',
        [
            CommunityController::class,
            'store'
        ]
    )->name('community.store');


    /*
    |--------------------------------------------------------------------------
    | EDIT COMMUNITY USER
    |--------------------------------------------------------------------------
    |
    | GET /komunitas/10/edit
    |
    | Ini adalah halaman USER.
    |
    | BUKAN:
    |
    | /admin/communities/10/edit
    |
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/komunitas/{community}/edit',
        [
            CommunityController::class,
            'edit'
        ]
    )->name('community.edit');


    /*
    |--------------------------------------------------------------------------
    | UPDATE COMMUNITY USER
    |--------------------------------------------------------------------------
    |
    | PUT /komunitas/10
    |
    |--------------------------------------------------------------------------
    */

    Route::put(
        '/komunitas/{community}',
        [
            CommunityController::class,
            'update'
        ]
    )->name('community.update');


    /*
    |--------------------------------------------------------------------------
    | JOIN COMMUNITY
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/komunitas/{community}/join',
        [
            CommunityController::class,
            'join'
        ]
    )->name('community.join');


    /*
    |--------------------------------------------------------------------------
    | LEAVE COMMUNITY
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/komunitas/{community}/leave',
        [
            CommunityController::class,
            'leave'
        ]
    )->name('community.leave');

});


/*
|--------------------------------------------------------------------------
| SHOW COMMUNITY
|--------------------------------------------------------------------------
|
| Route ini HARUS berada setelah:
|
| /komunitas/buat
| /komunitas/{community}/edit
|
|--------------------------------------------------------------------------
*/

Route::get(
    '/komunitas/{community}',
    [
        CommunityController::class,
        'show'
    ]
)->name('community.show');

/*
|--------------------------------------------------------------------------
| EVENT PUBLIC
|--------------------------------------------------------------------------
*/

Route::get(
    '/event',
    [
        EventController::class,
        'index'
    ]
)->name('event.index');


Route::get(
    '/event/{slug}',
    [
        EventController::class,
        'show'
    ]
)->name('event.show');


/*
|--------------------------------------------------------------------------
| TEAM
|--------------------------------------------------------------------------
*/

Route::get(
    '/team/{slug}',
    [
        TeamController::class,
        'show'
    ]
)->name('team.show');


/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

Route::get(
    '/search',
    [
        SearchController::class,
        'index'
    ]
)->name('search');


/*
|--------------------------------------------------------------------------
| LANGUAGE
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', function ($locale) {

    if (
        in_array(
            $locale,
            [
                'id',
                'en',
                'zh',
                'ja',
                'ko'
            ]
        )
    ) {

        Session::put(
            'locale',
            $locale
        );

        App::setLocale(
            $locale
        );
    }

    return redirect()
        ->back();

})->name('language');


/*
|--------------------------------------------------------------------------
| ADMIN CMS
|--------------------------------------------------------------------------
|
| Semua halaman admin:
|
| /admin/...
|
| Dilindungi oleh:
|
| auth:admin
| admin
|
|--------------------------------------------------------------------------
*/

Route::middleware([
        'auth:admin',
        'admin'
    ])
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
            [
                DashboardController::class,
                'index'
            ]
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
        | BLOG POSTS ADMIN
        |--------------------------------------------------------------------------
        |
        | Admin menggunakan ID artikel.
        |
        | Contoh:
        |
        | /admin/posts/13/edit
        |
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | INDEX
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/posts',
            [
                PostController::class,
                'index'
            ]
        )->name('posts.index');


        /*
        |--------------------------------------------------------------------------
        | EDIT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/posts/{post}/edit',
            [
                PostController::class,
                'edit'
            ]
        )->name('posts.edit');


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/posts/{post}',
            [
                PostController::class,
                'update'
            ]
        )->name('posts.update');


        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/posts/{post}',
            [
                PostController::class,
                'destroy'
            ]
        )->name('posts.destroy');


        /*
        |--------------------------------------------------------------------------
        | APPROVE
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/posts/{post}/approve',
            [
                PostController::class,
                'approve'
            ]
        )->name('posts.approve');


        /*
        |--------------------------------------------------------------------------
        | REJECT
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/posts/{post}/reject',
            [
                PostController::class,
                'reject'
            ]
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
        | COMMUNITY APPROVE
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/communities/{community}/approve',
            [
                AdminCommunityController::class,
                'approve'
            ]
        )->name('communities.approve');


        /*
        |--------------------------------------------------------------------------
        | COMMUNITY REJECT
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/communities/{community}/reject',
            [
                AdminCommunityController::class,
                'reject'
            ]
        )->name('communities.reject');


        /*
        |--------------------------------------------------------------------------
        | DETAIL
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/detail/{type}/{id}',
            [
                DetailController::class,
                'show'
            ]
        )->name('detail.show');


        /*
        |--------------------------------------------------------------------------
        | ADMIN LOGOUT
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/logout',
            [
                AuthController::class,
                'logout'
            ]
        )->name('logout');

    });