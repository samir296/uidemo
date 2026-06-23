<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingRequestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Models\BookingRequest;
use App\Models\ProviderOffering;
use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$marketplaceOfferings = static function () {
    return ProviderOffering::query()
        ->with('user')
        ->whereHas('user', function ($query) {
            $query->where('role', 'provider');
        })
        ->latest()
        ->get();
};

Route::get('/', function () use ($marketplaceOfferings) {
    return view('pages.home', [
        'offerings' => $marketplaceOfferings(),
    ]);
});

Route::get('/home', function () use ($marketplaceOfferings) {
    return view('pages.home', [
        'offerings' => $marketplaceOfferings(),
    ]);
})->name('home');

Route::get('/sitemap.xml', function () {
    $baseUrl = 'https://homiease.in';
    $staticUrls = collect([
        ['loc' => $baseUrl.'/', 'lastmod' => now()],
        ['loc' => $baseUrl.'/list', 'lastmod' => now()],
        ['loc' => $baseUrl.'/register', 'lastmod' => now()],
        ['loc' => $baseUrl.'/login', 'lastmod' => now()],
        ['loc' => $baseUrl.'/contact-us', 'lastmod' => now()],
        ['loc' => $baseUrl.'/provider-contact', 'lastmod' => now()],
        ['loc' => $baseUrl.'/support', 'lastmod' => now()],
    ]);

    $offeringUrls = ProviderOffering::query()
        ->latest('updated_at')
        ->take(500)
        ->get(['id', 'updated_at'])
        ->map(function (ProviderOffering $offering) use ($baseUrl): array {
            return [
                'loc' => $baseUrl.'/profile?offering='.$offering->id,
                'lastmod' => $offering->updated_at ?? now(),
            ];
        });

    $urls = $staticUrls->concat($offeringUrls);

    $xml = view('seo.sitemap', [
        'urls' => $urls,
    ])->render();

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/expert-main', function () {
    return redirect()->route('register', ['role' => 'provider']);
});

Route::get('/language/{locale}', function ($locale) {
    $supportedLocales = ['en', 'hi'];

    if (! in_array($locale, $supportedLocales, true)) {
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('language.switch');

// Priority pages
Route::get('/list', function () use ($marketplaceOfferings) {
    return view('pages.list', [
        'offerings' => $marketplaceOfferings(),
    ]);
});
Route::get('/profile', function (Request $request) {
    $offeringId = $request->integer('offering');

    $selectedOffering = ProviderOffering::query()
        ->with('user')
        ->when($offeringId, fn ($query) => $query->whereKey($offeringId))
        ->latest()
        ->first();

    return view('pages.profile', [
        'selectedOffering' => $selectedOffering,
    ]);
})->name('profile');
Route::get('/my-profile', [ProfileController::class, 'show'])->middleware('auth')->name('my.profile');
Route::put('/my-profile', [ProfileController::class, 'update'])->middleware('auth')->name('my.profile.update');
Route::get('/dashboard', function () {
    $user = auth()->user();

    if (! $user instanceof User) {
        return redirect()->guest(route('login'));
    }

    $user->load([
        'providerOfferings',
        'customerBookingRequests.provider',
        'customerBookingRequests.providerOffering',
        'providerBookingRequests.customer',
        'providerBookingRequests.providerOffering',
        'appNotifications',
    ]);

    return view('pages.dashboard', [
        'dashboardUser' => $user,
    ]);
})->name('dashboard');
Route::get('/login', function () { return view('pages.login'); })->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/register', function () { return view('pages.register'); })->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
})->name('logout');
Route::post('/device-token', function (Request $request) {
    $user = auth()->user();

    if (! $user instanceof User) {
        return redirect()->route('login');
    }

    $validated = $request->validate([
        'mobile_token' => ['required', 'string', 'max:4096'],
    ]);

    $user->updateMobileToken($validated['mobile_token']);

    return response()->json([
        'message' => 'Device token saved successfully.',
        'mobile_token_saved' => true,
    ]);
})->name('device.token.store');
Route::post('/booking-requests', [BookingRequestController::class, 'store'])->middleware('auth')->name('booking.requests.store');
Route::post('/booking-requests/{bookingRequest}/status', [BookingRequestController::class, 'updateStatus'])->middleware('auth')->name('booking.requests.update-status');
Route::get('/contact-us', function () { return view('pages.contact_us'); })->name('contact.user');
Route::get('/provider-contact', function () { return view('pages.provider_contact'); })->name('contact.provider');
Route::get('/support', function () { return view('pages.support'); })->name('support');
Route::get('/safty', function () { return view('pages.safty'); })->name('safety');
Route::get('/settings', function () { return view('pages.settings'); })->name('settings');
Route::get('/notifications', function () {
    $user = auth()->user();

    if (! $user instanceof User) {
        return redirect()->guest(route('login'));
    }

    return view('pages.notifications', [
        'notificationsFeed' => AppNotification::query()
            ->where('user_id', $user->id)
            ->latest()
            ->get(),
    ]);
})->name('notifications');
Route::get('/messages', function () { return view('pages.messages'); })->name('messages');
Route::get('/my-requests', function () {
    $user = auth()->user();

    if (! $user instanceof User) {
        return redirect()->guest(route('login'));
    }

    $bookingRequests = BookingRequest::query()
        ->with(['customer', 'provider', 'providerOffering'])
        ->when(
            $user->role === 'provider',
            fn ($query) => $query->where('provider_id', $user->id),
            fn ($query) => $query->where('customer_id', $user->id)
        )
        ->latest()
        ->get();

    return view('pages.my_requests', [
        'bookingRequests' => $bookingRequests,
    ]);
})->name('my.requests');
// Route::get('/write-review', function () { return view('pages.write-review'); });

// Include all pages routes
require __DIR__.'/all-pages-routes.php';

// Fallback for any remaining single-segment page routes.
Route::fallback(function () {
    $page = trim(request()->path(), '/');

    if ($page === '' || str_contains($page, '/')) {
        abort(404);
    }

    $pageName = str_replace('-', '_', $page);

    if (view()->exists("pages.{$pageName}")) {
        return view("pages.{$pageName}");
    }

    abort(404);
});
