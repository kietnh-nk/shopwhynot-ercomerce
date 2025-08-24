<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Fontend\HomeController;
use App\Http\Controllers\Fontend\ShopController;
use App\Http\Controllers\Ajax\AttributeController as AjaxAttributeController;
use App\Http\Controllers\Ajax\ProductController as AjaxProductController;
use App\Http\Controllers\Ajax\CartController as AjaxCartController;
use App\Http\Controllers\Ajax\WishlistController as AjaxWishlistController;
use App\Http\Controllers\Ajax\OrderController as AjaxOrderController;
use App\Http\Controllers\Ajax\SearchController as AjaxSearchController;
use App\Http\Controllers\Fontend\ProductController as FontendProductController;
use App\Http\Controllers\Fontend\PostController as FontendPostController;
use App\Http\Controllers\Ajax\ProductController as AjaxProductController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\RevenueController;
use App\Http\Controllers\Backend\AttributeCatalogueController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Ajax\AttributeController as AjaxAttributeController;
use App\Http\Controllers\Fontend\FPromotionController;
use App\Http\Controllers\Backend\ProductCatalogueController;
use App\Http\Controllers\Backend\PostCatalogueController;
use Illuminate\Support\Facades\Route;


// AJAX
//SEARCH SUGGESTION
Route::get('/ajax/search/suggestion', [AjaxSearchController::class, 'suggestion'])->name('ajax.search.suggestions');
// ATTRIBUTE
Route::get('/ajax/attribute/getAttribute', [AjaxAttributeController::class, 'getAttribute'])->name('ajax.attribute.getAttribute');
Route::get('/ajax/attribute/loadAttribute', [AjaxAttributeController::class, 'loadAttribute'])->name('ajax.attribute.loadAttribute');
Route::get('ajax/product/loadVariant', [AjaxProductController::class, 'loadVariant'])->name('ajax.loadVariant');
// WEB ROUTES
Route::get('/', [AuthController::class, 'index'])->name('home');
// AUTH
Route::get('login', [LoginController::class, 'index'])->name('auth.login');
Route::post('store-login', [LoginController::class, 'login'])->name('store.login');
Route::get('register', [RegisterController::class, 'index'])->name('auth.register');
Route::post('register-store', [RegisterController::class, 'register'])->name('store.register');
Route::get('/confirm-registration/{token}', [RegisterController::class, 'confirmRegistration'])->name('confirm.registration');

// FRONTEND REQUIRED LOGIN
Route::middleware(['auth'])->group(function () {
    //promotion
    Route::get('/promotion', [FPromotionController::class, 'index'])->name('promotion.home_index');
    Route::post('/receive/{promotion}', [FPromotionController::class, 'receivePromotion'])->name('promotion.receive');
});


//FRONTEND
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

// AJAX
//SEARCH SUGGESTION
Route::get('/ajax/search/suggestion', [AjaxSearchController::class, 'suggestion'])->name('ajax.search.suggestions');
// ATTRIBUTE 
Route::get('/ajax/attribute/getAttribute', [AjaxAttributeController::class, 'getAttribute'])->name('ajax.attribute.getAttribute');
Route::get('/ajax/attribute/loadAttribute', [AjaxAttributeController::class, 'loadAttribute'])->name('ajax.attribute.loadAttribute');
Route::get('ajax/product/loadVariant', [AjaxProductController::class, 'loadVariant'])->name('ajax.loadVariant');
// CART AJAX
Route::post('/ajax/cart/addToCart', [AjaxCartController::class, 'addToCart'])->name('ajax.cart.addToCart');
Route::post('/ajax/cart/updateCart', [AjaxCartController::class, 'updateCart'])->name('ajax.cart.updateCart');
Route::get('/ajax/cart/LoadOrderByCartId', [AjaxCartController::class, 'LoadOrderByCartId'])->name('ajax.cart.LoadOrderByCartId');
Route::post('/ajax/cart/sessionOrderByCartId', [AjaxCartController::class, 'sessionOrderByCartId'])->name('ajax.cart.sessionOrderByCartId');
Route::get('/ajax/cart/getOrderByCartId', [AjaxCartController::class, 'getOrderByCartId'])->name('ajax.cart.getOrderByCartId');
Route::post('/ajax/cart/clearSessionId', [AjaxCartController::class, 'clearSessionId'])->name('ajax.cart. ');
Route::delete('/ajax/cart/destroyCart', [AjaxCartController::class, 'destroyCart'])->name('ajax.cart.destroyCart');
Route::delete('/ajax/cart/clearCart', [AjaxCartController::class, 'clearCart'])->name('ajax.cart.clearCart');

// WISHLIST AJAX
Route::post('/ajax/wishlist/toggle', [AjaxWishlistController::class, 'toggle'])->name('ajax.wishlist.toggle');
Route::group(['prefix' => 'post'], function () {
    Route::get('page', [FontendPostController::class, 'index'])->name('post.page');
    Route::get('category/{id}', [FontendPostController::class, 'postInCategory'])->where(['id' => '[0-9]+'])->name('post.category');
    Route::get('detail/{slug}', [FontendPostController::class, 'detail'])->name('post.detail');
});

Route::group(['prefix' => 'cart'], function () {
    Route::get('index', [AjaxCartController::class, 'index'])->name('cart.index');
    Route::post('/apply-discount', [AjaxCartController::class, 'applyPromotion'])->name('cart.applyDiscount');
    Route::post('/remove-voucher/{voucherId}', [AjaxCartController::class, 'removeVoucher'])->name('cart.removeVoucher');
});

//BACKEND
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // usercatalogue
    Route::group(['prefix' => 'user/catalogue'], function () {
        Route::get('index', [UserCatalogueController::class, 'index'])->name('user.catalogue.index');
        Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create');
        Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
        Route::get('update/{slug}', [UserCatalogueController::class, 'update'])->name('user.catalogue.update');
        Route::post('edit/{slug}', [UserCatalogueController::class, 'edit'])->name('user.catalogue.edit');
        Route::get('delete/{id}', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete');
        Route::delete('destroy/{id}', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy');
    });
    // users
    Route::group(['prefix' => 'user/'], function () {
        Route::get('index', [UserController::class, 'index'])->name('user.index');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('update/{id}', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update');
        Route::post('edit/{id}', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit');
        Route::get('detail/{id}', [UserController::class, 'detail'])->where(['id' => '[0-9]+'])->name('user.detail');
        // Route::get('delete/{id}', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete');
        // Route::delete('destroy/{id}', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy');
    });

        // attribute catalogue
    Route::group(['prefix' => 'attribute/catalogue'], function () {
        Route::get('index', [AttributeCatalogueController::class, 'index'])->name('attribute.catalogue.index');
        Route::get('create', [AttributeCatalogueController::class, 'create'])->name('attribute.catalogue.create');
        Route::post('store', [AttributeCatalogueController::class, 'store'])->name('attribute.catalogue.store');
        Route::get('update/{slug}', [AttributeCatalogueController::class, 'update'])->name('attribute.catalogue.update');
        Route::post('edit/{slug}', [AttributeCatalogueController::class, 'edit'])->name('attribute.catalogue.edit');
        Route::get('delete/{id}', [AttributeCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.delete');
        Route::delete('destroy/{id}', [AttributeCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.destroy');
    });
        // attribute
    Route::group(['prefix' => 'attribute'], function () {
        Route::get('index', [AttributeController::class, 'index'])->name('attribute.index');
        Route::get('create', [AttributeController::class, 'create'])->name('attribute.create');
        Route::post('store', [AttributeController::class, 'store'])->name('attribute.store');
        Route::get('update/{slug}', [AttributeController::class, 'update'])->name('attribute.update');
        Route::post('edit/{slug}', [AttributeController::class, 'edit'])->name('attribute.edit');
        Route::get('delete/{id}', [AttributeController::class, 'delete'])->where(['id' => '[0-9]+'])->name('attribute.delete');
        Route::delete('destroy/{id}', [AttributeController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('attribute.destroy');
    });
        //product
    Route::group(['prefix' => 'product'], function () {
        Route::get('index', [ProductController::class, 'index'])->name('product.index');
        Route::get('create', [ProductController::class, 'create'])->name('product.create');
        Route::post('store', [ProductController::class, 'store'])->name('product.store');
        Route::get('update/{slug}', [ProductController::class, 'update'])->name('product.update');
        Route::post('edit/{slug}', [ProductController::class, 'edit'])->name('product.edit');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->where(['id' => '[0-9]+'])->name('product.delete');
        Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('product.destroy');
    });
        // product catalogue
    Route::group(['prefix' => 'product/catalogue'], function () {
        Route::get('index', [ProductCatalogueController::class, 'index'])->name('product.catalogue.index');
        Route::get('create', [ProductCatalogueController::class, 'create'])->name('product.catalogue.create');
        Route::post('store', [ProductCatalogueController::class, 'store'])->name('product.catalogue.store');
        Route::get('update/{slug}', [ProductCatalogueController::class, 'update'])->name('product.catalogue.update');
        Route::post('edit/{slug}', [ProductCatalogueController::class, 'edit'])->name('product.catalogue.edit');
        Route::get('delete/{id}', [ProductCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('product.catalogue.delete');
        Route::delete('destroy/{id}', [ProductCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('product.catalogue.destroy');
    });
    //posts
    Route::group(['prefix' => 'post'], function () {
        Route::get('index', [PostController::class, 'index'])->name('post.index');
        Route::get('create', [PostController::class, 'create'])->name('post.create');
        Route::post('store', [PostController::class, 'store'])->name('post.store');
        Route::get('update/{slug}', [PostController::class, 'update'])->name('post.update');
        Route::post('edit/{slug}', [PostController::class, 'edit'])->name('post.edit');
        Route::get('delete/{id}', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.delete');
        Route::delete('destroy/{id}', [PostController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.destroy');
    });
    //post catalogues
    Route::group(['prefix' => 'post/catalogue'], function () {
        Route::get('index', [PostCatalogueController::class, 'index'])->name('post.catalogue.index');
        Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create');
        Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store');
        Route::get('update/{slug}', [PostCatalogueController::class, 'update'])->name('post.catalogue.update');
        Route::post('edit/{slug}', [PostCatalogueController::class, 'edit'])->name('post.catalogue.edit');
        Route::get('delete/{id}', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete');
        Route::delete('destroy/{id}', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.catalogue.destroy');
    });
    //Doanh thu
    Route::get('/admin/revenue', [RevenueController::class, 'index'])->name('revenue.index');
    Route::post('/admin/thong-ke-data', [RevenueController::class, 'Thongke']);
});


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
