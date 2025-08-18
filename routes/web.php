<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Fontend\HomeController;
use App\Http\Controllers\Fontend\ShopController;
use App\Http\Controllers\Ajax\SearchController as AjaxSearchController;
use App\Http\Controllers\Fontend\ProductController as FontendProductController;


use Illuminate\Support\Facades\Route;

// WEB ROUTES
Route::get('/', [AuthController::class, 'index'])->name('home');
// AUTH
Route::get('login', [LoginController::class, 'index'])->name('auth.login');
Route::post('store-login', [LoginController::class, 'login'])->name('store.login');
Route::get('register', [RegisterController::class, 'index'])->name('auth.register');
Route::post('register-store', [RegisterController::class, 'register'])->name('store.register');
Route::get('/confirm-registration/{token}', [RegisterController::class, 'confirmRegistration'])->name('confirm.registration');

Route::get('/password/confirm_email', [ForgotPasswordController::class, 'emailForm'])->name('password.confirm_email');
Route::post('/password/email', [ForgotPasswordController::class, 'sendEmail'])->name('password.email');
Route::get('/password/verify-otp', [ForgotPasswordController::class, 'otpForm'])->name('password.otp');
Route::post('/password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.submit');
Route::get('/password/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.otp.resend');
Route::get('/password/reset', [ForgotPasswordController::class, 'resetForm'])->name('password.reset');
Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

//Page 404
Route::fallback(function () {
    return view('fontend.error.404');
});
//FRONEND
Route::get('/', [HomeController::class, 'index'])->name('home_index.index');
Route::get('home', [HomeController::class, 'index'])->name('home.index');
Route::get('shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('product/category/{id}', [ShopController::class, 'productIncategory'])->where(['id' => '[0-9]+'])->name('product.category');
Route::get('product/brand/{id}', [ShopController::class, 'productInBrand'])->where(['id' => '[0-9]+'])->name('product.brand');
Route::get('product/filter', [ShopController::class, 'productFilter'])->name('product.filter');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('product/detail/{slug}', [FontendProductController::class, 'detail'])->name('product.detail');
Route::get('search', [AjaxSearchController::class, 'search'])->name('search');
//Page orther
Route::get('faq', [HomeController::class, 'faq'])->name('home.faq');
Route::get('/contact', [HomeController::class, 'showForm'])->name('home.contact');
Route::post('/contact/send', [HomeController::class, 'send'])->name('contact.send');
Route::get('terms_and_conditions', [HomeController::class, 'terms_and_conditions'])->name('home.terms_and_conditions');
Route::get('return_and_warranty_policy', [HomeController::class, 'return_and_warranty_policy'])->name('home.return_and_warranty_policy');
Route::get('about_us', [HomeController::class, 'about_us'])->name('home.about_us');
Route::get('security_center', [HomeController::class, 'security_center'])->name('home.security_center');


//BACKEND
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


});
