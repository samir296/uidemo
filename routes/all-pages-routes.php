<?php

// All pages route map
$pages = [
    'booking-success',
    'edit-profile',
    'expert-main',
    'expert-reviews', // .htm -> .blade.php
    'expertserviceform',
    'favorites',
    'help Asc -center',
    'language_select',
    'live-tracking',
    'sos-setup',
    'track-service',
    'work-history'
];

foreach ($pages as $page) {
    Route::get("/$page", function () use ($page) {
        $bladeName = str_replace(['-', '_'], '_', $page);
        return view("pages.{$bladeName}");
    });
}

// Note: expert-reviews.htm -> expert_reviews.blade.php
Route::get('/expert-reviews', function () {
    return view('pages.expert_reviews');
});

Route::get('/expert-reviews', function () {
    return view('pages.expert_reviews');
});
