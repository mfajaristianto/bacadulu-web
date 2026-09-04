<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookstoreController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\DataArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HakiController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminGoogleVerificationController;
use App\Http\Controllers\Admin\AdminRecoveryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CommunityController as AdminCommunityController;
use App\Http\Controllers\Admin\ConferenceAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataArticleAdminController;
use App\Http\Controllers\Admin\DetailController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\InformationAdminController;
use App\Http\Controllers\Admin\JurnalAdminController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PublisherAdminController;

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
| USER AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/auth/google', [
    GoogleController::class,
    'redirect',
])->name('google.login');

Route::get('/auth/google/callback', [
    GoogleController::class,
    'callback',
])->name('google.callback');

Route::post('/logout', function () {
    auth()->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| USER PROFILE
|--------------------------------------------------------------------------
*/

Route::get('/avatar/google/{user}', [
    ProfileController::class,
    'googleAvatar',
])->name('profile.google-avatar');

Route::middleware('auth')
    ->prefix('profil')
    ->name('profile.')
    ->group(function () {

        Route::get('/', [
            ProfileController::class,
            'edit',
        ])->name('edit');

        Route::post('/foto', [
            ProfileController::class,
            'updatePhoto',
        ])->name('photo.update');

        Route::patch('/foto/google', [
            ProfileController::class,
            'useGoogle',
        ])->name('photo.google');

        Route::patch('/foto/inisial', [
            ProfileController::class,
            'useInitials',
        ])->name('photo.initials');
    });

/*
|--------------------------------------------------------------------------
| ADMIN AUTH & RECOVERY
|--------------------------------------------------------------------------
*/

Route::prefix('panel-adminbaca')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Login
        |--------------------------------------------------------------------------
        */

        Route::get('/login', [
            AdminAuthController::class,
            'showLoginForm',
        ])->name('login');

        Route::post('/login', [
            AdminAuthController::class,
            'login',
        ])
            ->middleware('throttle:5,1')
            ->name('login.submit');

        /*
        |--------------------------------------------------------------------------
        | Forgot Password
        |--------------------------------------------------------------------------
        */

        Route::get('/forgot-password', [
            AdminRecoveryController::class,
            'showForm',
        ])->name('recovery.form');

        Route::post('/forgot-password', [
            AdminRecoveryController::class,
            'store',
        ])
            ->middleware('throttle:5,10')
            ->name('recovery.store');

        Route::get('/forgot-password/waiting/{publicId}', [
            AdminRecoveryController::class,
            'waiting',
        ])->name('recovery.waiting');

        /*
        |--------------------------------------------------------------------------
        | Recovery Approval
        |--------------------------------------------------------------------------
        */

        Route::get('/forgot-password/review/{publicId}/{decision}', [
            AdminRecoveryController::class,
            'review',
        ])
            ->middleware(['signed', 'throttle:20,1'])
            ->whereIn('decision', ['approve', 'reject'])
            ->name('recovery.review');

        Route::post('/forgot-password/review/{publicId}/{decision}', [
            AdminRecoveryController::class,
            'decision',
        ])
            ->middleware(['signed', 'throttle:10,1'])
            ->whereIn('decision', ['approve', 'reject'])
            ->name('recovery.decision');

        /*
        |--------------------------------------------------------------------------
        | Create Access Password
        |--------------------------------------------------------------------------
        */

        Route::get('/forgot-password/create-password/{publicId}', [
            AdminRecoveryController::class,
            'showPasswordForm',
        ])
            ->middleware('signed')
            ->name('recovery.password.create');

        Route::post('/forgot-password/create-password/{publicId}', [
            AdminRecoveryController::class,
            'storePassword',
        ])
            ->middleware(['signed', 'throttle:10,1'])
            ->name('recovery.password.store');

        /*
        |--------------------------------------------------------------------------
        | Google Verification
        |--------------------------------------------------------------------------
        */

        Route::get('/google-verification', [
            AdminGoogleVerificationController::class,
            'show',
        ])->name('google.verify');

        Route::get('/google-verification/redirect', [
            AdminGoogleVerificationController::class,
            'redirect',
        ])->name('google.redirect');

        Route::get('/google-verification/callback', [
            AdminGoogleVerificationController::class,
            'callback',
        ])->name('google.callback');

        /*
        |--------------------------------------------------------------------------
        | OTP
        |--------------------------------------------------------------------------
        */

        Route::get('/verify-otp', [
            AdminAuthController::class,
            'showOtpForm',
        ])->name('otp');

        Route::post('/verify-otp', [
            AdminAuthController::class,
            'processOtp',
        ])
            ->middleware('throttle:5,5')
            ->name('otp.submit');

        /*
        |--------------------------------------------------------------------------
        | Confirm Access
        |--------------------------------------------------------------------------
        */

        Route::get('/confirm-access', [
            AdminAuthController::class,
            'showConfirmForm',
        ])->name('confirm');

        Route::post('/confirm-access', [
            AdminAuthController::class,
            'processConfirm',
        ])
            ->middleware('throttle:5,5')
            ->name('confirm.submit');
    });

/*
|--------------------------------------------------------------------------
| INFORMATION
|--------------------------------------------------------------------------
*/

Route::get('/information', [
    InformationController::class,
    'index',
])->name('informasi');

Route::get('/information/{information:slug}', [
    InformationController::class,
    'show',
])->name('informasi.show');

/*
|--------------------------------------------------------------------------
| ARTICLES
|--------------------------------------------------------------------------
*/

Route::get('/articles', [
    DataArticleController::class,
    'index',
])->name('articles');

/*
|--------------------------------------------------------------------------
| JURNAL
|--------------------------------------------------------------------------
*/

Route::get('/jurnal', [
    JurnalController::class,
    'index',
])->name('jurnal');

/*
|--------------------------------------------------------------------------
| CONFERENCE
|--------------------------------------------------------------------------
*/

Route::get('/conference', [
    ConferenceController::class,
    'index',
])->name('conference');

/*
|--------------------------------------------------------------------------
| PUBLISHER
|--------------------------------------------------------------------------
*/

Route::get('/publisher', [
    PublisherController::class,
    'index',
])->name('publisher');

Route::get('/publisher/books/{book}', [
    PublisherController::class,
    'show',
])->name('publisher.books.show');

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

Route::get('/haki', [
    HakiController::class,
    'index',
])->name('haki.index');

Route::get('/haki/daftar/{jenis}', function ($jenis) {
    return view('landing-page.pages.haki', [
        'jenis' => $jenis,
    ]);
})->name('haki.daftar');

/*
|--------------------------------------------------------------------------
| TENTANG
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

Route::get('/portofolio/bookstore', [
    BookstoreController::class,
    'index',
])->name('portofolio.bookstore');

Route::get('/portofolio/bookstore/{book:slug}', [
    BookstoreController::class,
    'show',
])->name('portofolio.bookstore.show');

/*
|--------------------------------------------------------------------------
| BLOG
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Blog Public
|--------------------------------------------------------------------------
*/

Route::get('/blog', [
    BlogController::class,
    'index',
])->name('blog.index');

/*
|--------------------------------------------------------------------------
| Blog Authenticated
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Create Article
    |--------------------------------------------------------------------------
    */

    Route::get('/blog/create', [
        BlogController::class,
        'create',
    ])->name('blog.create');

    Route::post('/blog', [
        BlogController::class,
        'store',
    ])->name('blog.store');

    /*
    |--------------------------------------------------------------------------
    | My Articles
    |--------------------------------------------------------------------------
    */

    Route::get('/blog/saya', [
        BlogController::class,
        'myPosts',
    ])->name('blog.myPosts');

    /*
    |--------------------------------------------------------------------------
    | Edit Article
    |--------------------------------------------------------------------------
    */

    Route::get('/blog/{post:slug}/edit', [
        BlogController::class,
        'edit',
    ])->name('blog.edit');

    Route::put('/blog/{post:slug}', [
        BlogController::class,
        'update',
    ])->name('blog.update');

    Route::delete('/blog/{post:slug}', [
        BlogController::class,
        'destroy',
    ])->name('blog.destroy');

    /*
    |--------------------------------------------------------------------------
    | Like Article
    |--------------------------------------------------------------------------
    */

    Route::post('/blog/{post:slug}/like', [
        BlogController::class,
        'toggleLike',
    ])->name('blog.like');

    /*
    |--------------------------------------------------------------------------
    | Comments
    |--------------------------------------------------------------------------
    */

    Route::post('/blog/{post:slug}/comments', [
        CommentController::class,
        'store',
    ])->name('post.comment.store');

    Route::put('/blog/comments/{comment}', [
        CommentController::class,
        'update',
    ])->name('post.comment.update');

    Route::delete('/blog/comments/{comment}', [
        CommentController::class,
        'destroy',
    ])->name('post.comment.destroy');
});

/*
|--------------------------------------------------------------------------
| Show Article
|--------------------------------------------------------------------------
|
| WAJIB di bawah /blog/create dan /blog/saya supaya slug
| tidak menangkap URL statis tersebut.
|
*/

Route::get('/blog/{post:slug}', [
    BlogController::class,
    'show',
])->name('blog.show');

/*
|--------------------------------------------------------------------------
| COMMUNITY
|--------------------------------------------------------------------------
*/

Route::get('/komunitas', [
    CommunityController::class,
    'index',
])->name('community.index');

Route::middleware('auth')->group(function () {

    Route::get('/komunitas/buat', [
        CommunityController::class,
        'create',
    ])->name('community.create');

    Route::post('/komunitas', [
        CommunityController::class,
        'store',
    ])->name('community.store');

    Route::get('/komunitas/{community}/edit', [
        CommunityController::class,
        'edit',
    ])->name('community.edit');

    Route::put('/komunitas/{community}', [
        CommunityController::class,
        'update',
    ])->name('community.update');

    Route::post('/komunitas/{community}/join', [
        CommunityController::class,
        'join',
    ])->name('community.join');

    Route::post('/komunitas/{community}/leave', [
        CommunityController::class,
        'leave',
    ])->name('community.leave');
});

Route::get('/komunitas/{community}', [
    CommunityController::class,
    'show',
])->name('community.show');

/*
|--------------------------------------------------------------------------
| EVENT
|--------------------------------------------------------------------------
*/

Route::get('/event', [
    EventController::class,
    'index',
])->name('event.index');

Route::get('/event/{slug}', [
    EventController::class,
    'show',
])->name('event.show');

/*
|--------------------------------------------------------------------------
| TEAM
|--------------------------------------------------------------------------
*/

Route::get('/team/{slug}', [
    TeamController::class,
    'show',
])->name('team.show');

/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

Route::get('/search', [
    SearchController::class,
    'index',
])->name('search');

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
*/

Route::middleware(['auth:admin', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', [
            DashboardController::class,
            'index',
        ])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Books
        |--------------------------------------------------------------------------
        */

        // Books
Route::post('books/{book:slug}/stock/add', [
    AdminBookController::class,
    'addStock',
])->name('books.stock.add');

Route::post('books/{book:slug}/stock/sale', [
    AdminBookController::class,
    'recordSale',
])->name('books.stock.sale');

Route::resource('books', AdminBookController::class)
    ->scoped([
        'book' => 'slug',
    ]);

        /*
|--------------------------------------------------------------------------
| Informations
|--------------------------------------------------------------------------
*/

Route::patch(
    'informations/{information}/pin',
    [
        InformationAdminController::class,
        'togglePin',
    ]
)->name('informations.pin');

Route::resource(
    'informations',
    InformationAdminController::class
);
        


        /*
        |--------------------------------------------------------------------------
        | Journals
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'journals',
            JurnalAdminController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Conferences
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'conferences',
            ConferenceAdminController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Publishers
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'publishers',
            PublisherAdminController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Data Articles
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'data-articles',
            DataArticleAdminController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Posts
        |--------------------------------------------------------------------------
        */

        Route::get('/posts', [
            PostController::class,
            'index',
        ])->name('posts.index');

        Route::get('/posts/{post}/edit', [
            PostController::class,
            'edit',
        ])->name('posts.edit');

        Route::put('/posts/{post}', [
            PostController::class,
            'update',
        ])->name('posts.update');

        Route::delete('/posts/{post}', [
            PostController::class,
            'destroy',
        ])->name('posts.destroy');

        Route::post('/posts/{post}/approve', [
            PostController::class,
            'approve',
        ])->name('posts.approve');

        Route::post('/posts/{post}/reject', [
            PostController::class,
            'reject',
        ])->name('posts.reject');

        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'events',
            EventAdminController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Communities
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'communities',
            AdminCommunityController::class
        );

        Route::post('/communities/{community}/approve', [
            AdminCommunityController::class,
            'approve',
        ])->name('communities.approve');

        Route::post('/communities/{community}/reject', [
            AdminCommunityController::class,
            'reject',
        ])->name('communities.reject');

        /*
        |--------------------------------------------------------------------------
        | Detail
        |--------------------------------------------------------------------------
        */

        Route::get('/detail/{type}/{id}', [
            DetailController::class,
            'show',
        ])->name('detail.show');

        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */

        Route::post('/logout', [
            AuthController::class,
            'logout',
        ])->name('logout');
    });