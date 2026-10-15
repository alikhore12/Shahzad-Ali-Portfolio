<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Shahzad Labs
|--------------------------------------------------------------------------
|
| Public pages: Home, Projects, Project Detail, Skills, Services, Contact.
| Admin management: Dashboard, Projects CRUD, Skills CRUD, Messages, Profile.
|
*/

// ── Public Pages & Portfolio ─────────────────────────────────────────
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.index');
Route::get('/projects/{slug}', [PortfolioController::class, 'projectShow'])->name('projects.show');
Route::get('/skills', [PortfolioController::class, 'skills'])->name('skills.index');
Route::get('/services', [PortfolioController::class, 'services'])->name('services.index');
Route::get('/contact', [PortfolioController::class, 'contactPage'])->name('contact.index');
Route::post('/contact', [PortfolioController::class, 'contact'])->name('contact.submit');
Route::get('/sitemap.xml', [PortfolioController::class, 'sitemap'])->name('sitemap');

// ── Admin Dashboard (protected) ──────────────────────────────────────
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard overview
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Projects CRUD
    Route::resource('projects', ProjectController::class);

    // Skills CRUD
    Route::resource('skills', SkillController::class);

    // Messages / Inquiries
    Route::get('/messages', [DashboardController::class, 'messages'])->name('messages');
    Route::get('/messages/{message}', [DashboardController::class, 'showMessage'])->name('messages.show');
    Route::delete('/messages/{message}', [DashboardController::class, 'destroyMessage'])->name('messages.destroy');

    // Site Branding & Settings (Hero Image, Logo, Favicon)
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

    // Profile (Admin routes)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Standard Breeze profile route aliases
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redirect old /dashboard to new admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
