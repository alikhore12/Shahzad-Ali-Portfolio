<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the Laravel RequestHandler. You can create a group
| which contains middleware that you like to apply to every request, such
| as "auth", "role", and others. Just build a great application!
|
*/

Auth::routes(['register' => false, 'reset' => false]);

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class)->except(['show']);
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class)->except(['show']);
    Route::resource('skills', App\Http\Controllers\Admin\SkillController::class)->except(['show']);
    Route::resource('education', App\Http\Controllers\Admin\EducationController::class)->except(['show']);
    Route::resource('experiences', App\Http\Controllers\Admin\ExperienceController::class)->except(['show']);
    Route::resource('certifications', App\Http\Controllers\Admin\CertificationController::class)->except(['show']);
    Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class)->except(['show']);
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class)->except(['show']);

    Route::patch('contact-messages/read-all', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAllRead'])->name('contact-messages.read-all');
    Route::patch('contact-messages/{message}/read', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markRead'])->name('contact-messages.read');
    Route::resource('contact-messages', App\Http\Controllers\Admin\ContactMessageController::class)
        ->only(['index', 'show', 'destroy'])
        ->parameters(['contact-messages' => 'message']);

    Route::resource('social-links', App\Http\Controllers\Admin\SocialLinkController::class)
        ->only(['store', 'update', 'destroy'])
        ->parameters(['social-links' => 'socialLink']);

    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    Route::get('about', [\App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('about.edit');
    Route::put('about', [\App\Http\Controllers\Admin\AboutController::class, 'update'])->name('about.update');

    Route::get('seo', [\App\Http\Controllers\Admin\SeoSettingsController::class, 'edit'])->name('seo.edit');
    Route::put('seo', [\App\Http\Controllers\Admin\SeoSettingsController::class, 'update'])->name('seo.update');

    Route::get('settings', [\App\Http\Controllers\Admin\WebsiteSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [\App\Http\Controllers\Admin\WebsiteSettingsController::class, 'update'])->name('settings.update');
});

Route::get('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Portfolio routes
Route::get('/portfolio', [App\Http\Controllers\PortfolioController::class, 'projects'])->name('portfolio');
Route::get('/portfolio/{slug}', [App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects', [App\Http\Controllers\PortfolioController::class, 'projects'])->name('projects');
Route::get('/assets/portfolio.css', function () {
    return response()->file(resource_path('css/app.css'), ['Content-Type' => 'text/css']);
})->name('portfolio.css');
Route::get('/assets/portfolio-pages.css', function () {
    return response()->file(resource_path('css/pages.css'), ['Content-Type' => 'text/css']);
})->name('portfolio.pages.css');
Route::get('/assets/admin.css', function () {
    return response()->file(resource_path('css/admin.css'), ['Content-Type' => 'text/css']);
})->name('admin.assets.css');
Route::get('/assets/admin.js', function () {
    return response()->file(resource_path('js/admin.js'), ['Content-Type' => 'application/javascript']);
})->name('admin.assets.js');

Route::get('/profile-image', function () {
    $profilePath = \App\Models\Profile::value('image_path');
    $absolutePath = $profilePath ? public_path($profilePath) : null;
    $fallbackPath = public_path('images/shahzad-ali.png');

    return response()->file(is_file($absolutePath) ? $absolutePath : $fallbackPath, [
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
    ]);
})->name('profile.image');

Route::get('/profile-favicon.svg', function () {
    $profilePath = \App\Models\Profile::value('image_path');
    $absolutePath = $profilePath ? public_path($profilePath) : public_path('images/shahzad-ali.png');
    $mime = mime_content_type($absolutePath) ?: 'image/jpeg';
    $imageData = base64_encode((string) file_get_contents($absolutePath));
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><defs><clipPath id="circle"><circle cx="32" cy="32" r="30"/></clipPath></defs><circle cx="32" cy="32" r="31" fill="#ffffff"/><image href="data:'.$mime.';base64,'.$imageData.'" x="2" y="2" width="60" height="60" preserveAspectRatio="xMidYMid slice" clip-path="url(#circle)"/></svg>';
    return response($svg, 200, ['Content-Type' => 'image/svg+xml', 'Cache-Control' => 'no-cache, no-store, must-revalidate']);
})->name('profile.favicon');

// Home page
Route::get('/', [App\Http\Controllers\PortfolioController::class, 'home'])->name('home');

// Portfolio pages
Route::redirect('/about', '/about-us');
Route::get('/about-us', [App\Http\Controllers\PortfolioController::class, 'about'])->name('about');
Route::get('/skills', [App\Http\Controllers\PortfolioController::class, 'skills'])->name('skills');
Route::get('/skills/{slug}', [App\Http\Controllers\PortfolioController::class, 'skillDetail'])->name('skills.show');
Route::get('/services', [App\Http\Controllers\PortfolioController::class, 'services'])->name('services');
Route::get('/services/{slug}', [App\Http\Controllers\PortfolioController::class, 'serviceDetail'])->name('services.show');
Route::get('/experience', [App\Http\Controllers\PortfolioController::class, 'experience'])->name('experience');
Route::get('/education', [App\Http\Controllers\PortfolioController::class, 'education'])->name('education');
Route::get('/resume', [App\Http\Controllers\PortfolioController::class, 'resume'])->name('resume');
Route::get('/contact', [App\Http\Controllers\PortfolioController::class, 'contactPage'])->name('contact');
Route::post('/contact', [App\Http\Controllers\PortfolioController::class, 'contact'])->name('contact.store');

Route::get('/sitemap.xml', [App\Http\Controllers\PortfolioController::class, 'sitemap'])->name('sitemap');
