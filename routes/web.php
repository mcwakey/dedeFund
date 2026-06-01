<?php

use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationIntentController;
use App\Http\Controllers\Admin\InternshipApplicationController;
use App\Http\Controllers\Admin\InterventionAreaController;
use App\Http\Controllers\Admin\PostManagementController;
use App\Http\Controllers\Admin\ProjectManagementController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\VolunteerApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\FormSubmissionController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/index.php/{path?}', function (?string $path = null) {
    return redirect('/'.ltrim((string) $path, '/'), 301);
})->where('path', '.*');

Route::get('/build/{path}', function (string $path) {
    abort_if(str_contains($path, '..'), 404);

    $file = public_path('build/'.$path);
    abort_unless(is_file($file), 404);

    $contentType = match (pathinfo($file, PATHINFO_EXTENSION)) {
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        default => mime_content_type($file) ?: 'application/octet-stream',
    };

    return response()->file($file, ['Content-Type' => $contentType]);
})->where('path', '.*')->name('local.assets');

Route::redirect('/', '/fr');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::pattern('locale', 'fr|en');

Route::prefix('{locale}')->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/actions', [PageController::class, 'actions'])->name('actions');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

    Route::get('/donate', [PageController::class, 'donate'])->name('donate');
    Route::post('/donate', [FormSubmissionController::class, 'donation'])->name('donation.store');

    Route::get('/volunteer', [PageController::class, 'volunteer'])->name('volunteer');
    Route::post('/volunteer', [FormSubmissionController::class, 'volunteer'])->name('volunteer.store');

    Route::get('/internships', [PageController::class, 'internships'])->name('internships');
    Route::post('/internships', [FormSubmissionController::class, 'internship'])->name('internships.store');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [FormSubmissionController::class, 'contact'])->name('contact.store');

    Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/files/{path}', function (string $path) {
        abort_if(str_contains($path, '..'), 404);
        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->download($path);
    })->where('path', '.*')->name('files.show');

    Route::resource('areas', InterventionAreaController::class)->except('show');
    Route::resource('projects', ProjectManagementController::class)->except('show');
    Route::resource('posts', PostManagementController::class)->except('show');
    Route::resource('donations', DonationIntentController::class)->only(['index', 'show', 'update']);
    Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'update']);
    Route::resource('volunteers', VolunteerApplicationController::class)->only(['index', 'show', 'update']);
    Route::resource('internships', InternshipApplicationController::class)->only(['index', 'show', 'update']);
    Route::get('settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
