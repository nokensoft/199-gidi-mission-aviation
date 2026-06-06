<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;

// PUBLIC ROUTES
Route::middleware('track.visitor')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/donasi', [HomeController::class, 'storeDonation'])->name('donation.store');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('page.show');
});

// AUTH
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ADMIN
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visitor-data', [DashboardController::class, 'visitorData'])->name('visitor.data');

    Route::middleware('admin')->group(function () {
        // Trash routes (sebelum resource agar tidak konflik)
        Route::get('posts/trash', [PostController::class, 'trash'])->name('posts.trash');
        Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
        Route::delete('posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');
        Route::get('donations/trash', [DonationController::class, 'trash'])->name('donations.trash');
        Route::post('donations/{id}/restore', [DonationController::class, 'restore'])->name('donations.restore');
        Route::delete('donations/{id}/force-delete', [DonationController::class, 'forceDelete'])->name('donations.force-delete');
        Route::get('testimonials/trash', [TestimonialController::class, 'trash'])->name('testimonials.trash');
        Route::post('testimonials/{id}/restore', [TestimonialController::class, 'restore'])->name('testimonials.restore');
        Route::delete('testimonials/{id}/force-delete', [TestimonialController::class, 'forceDelete'])->name('testimonials.force-delete');
        Route::get('sliders/trash', [SliderController::class, 'trash'])->name('sliders.trash');
        Route::post('sliders/{id}/restore', [SliderController::class, 'restore'])->name('sliders.restore');
        Route::delete('sliders/{id}/force-delete', [SliderController::class, 'forceDelete'])->name('sliders.force-delete');
        Route::get('services/trash', [ServiceController::class, 'trash'])->name('services.trash');
        Route::post('services/{id}/restore', [ServiceController::class, 'restore'])->name('services.restore');
        Route::delete('services/{id}/force-delete', [ServiceController::class, 'forceDelete'])->name('services.force-delete');
        Route::get('partners/trash', [PartnerController::class, 'trash'])->name('partners.trash');
        Route::post('partners/{id}/restore', [PartnerController::class, 'restore'])->name('partners.restore');
        Route::delete('partners/{id}/force-delete', [PartnerController::class, 'forceDelete'])->name('partners.force-delete');

        // Resource routes
        Route::resource('posts', PostController::class)->except('show');
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
        Route::get('donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
        Route::post('donations/{donation}/confirm', [DonationController::class, 'confirm'])->name('donations.confirm');
        Route::post('donations/{donation}/reject', [DonationController::class, 'reject'])->name('donations.reject');
        Route::post('donations/{donation}/upload-proof', [DonationController::class, 'uploadProof'])->name('donations.upload-proof');
        Route::delete('donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');
        Route::get('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
        Route::get('testimonials/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
        Route::put('testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
        Route::post('testimonials/{testimonial}/toggle-approval', [TestimonialController::class, 'toggleApproval'])->name('testimonials.toggle-approval');
        Route::post('testimonials/{testimonial}/toggle-featured', [TestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle-featured');
        Route::delete('testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
        Route::resource('sliders', SliderController::class)->except('show');
        Route::get('services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('services', [ServiceController::class, 'store'])->name('services.store');
        Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        Route::get('partners', [PartnerController::class, 'index'])->name('partners.index');
        Route::post('partners', [PartnerController::class, 'store'])->name('partners.store');
        Route::put('partners/{partner}', [PartnerController::class, 'update'])->name('partners.update');
        Route::delete('partners/{partner}', [PartnerController::class, 'destroy'])->name('partners.destroy');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('settings/pages', [SettingController::class, 'pages'])->name('settings.pages');
        Route::get('settings/pages/{page}/edit', [SettingController::class, 'editPage'])->name('settings.pages.edit');
        Route::put('settings/pages/{page}', [SettingController::class, 'updatePage'])->name('settings.pages.update');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::put('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
