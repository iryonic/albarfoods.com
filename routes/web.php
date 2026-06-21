<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;

// 1. Homepage Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Catalog & Search Routes
Route::get('/shop', [CatalogController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [CatalogController::class, 'product'])->name('product.details');

// 3. Authentication & Sign Up Routes
Route::get('/signin', [AuthController::class, 'showSignin'])->name('signin');
Route::post('/signin', [AuthController::class, 'signin']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 4. Cart & Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'placeOrder']);
Route::get('/order-success', [CheckoutController::class, 'success'])->name('order-success');
Route::post('/cart/sync', [\App\Http\Controllers\CartController::class, 'sync']);

// 5. Customer Profile & Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::post('/orders/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::post('/orders/return', [OrderController::class, 'requestReturn'])->name('orders.return');
Route::get('/track-order', [OrderController::class, 'track'])->name('track-order');
Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
Route::post('/profile', [CustomerController::class, 'updateProfile']);
Route::post('/profile/address', [CustomerController::class, 'updateAddress'])->name('profile.address');
Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');

// Customer Support Ticket Routes
Route::get('/tickets', [App\Http\Controllers\SupportController::class, 'index'])->name('tickets');
Route::post('/tickets', [App\Http\Controllers\SupportController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{id}', [App\Http\Controllers\SupportController::class, 'show'])->name('tickets.show');
Route::post('/tickets/{id}/reply', [App\Http\Controllers\SupportController::class, 'reply'])->name('tickets.reply');
Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

// 6. CMS static pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendMessage']);
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/offline', [PageController::class, 'offline'])->name('offline');

// 7. Admin Panel Routes (Phase 4 / Dashboard & Product Management)
 
Route::get('/admin', function () {
    return redirect('/admin/dashboard');
})->name('admin');

Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function() {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [App\Http\Controllers\AdminController::class, 'products'])->name('products');
    Route::post('/products', [App\Http\Controllers\AdminController::class, 'storeProduct'])->name('products.store');
    Route::put('/products/{id}', [App\Http\Controllers\AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('products.delete');
    Route::post('/products/bulk-status', [App\Http\Controllers\AdminController::class, 'bulkUpdateProductsStatus'])->name('products.bulk-status');
    Route::post('/products/{productId}/variants', [App\Http\Controllers\AdminController::class, 'storeVariant'])->name('variants.store');
    Route::put('/products/variants/{id}', [App\Http\Controllers\AdminController::class, 'updateVariant'])->name('variants.update');
    Route::delete('/products/variants/{id}', [App\Http\Controllers\AdminController::class, 'deleteVariant'])->name('variants.delete');
    Route::get('/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/status', [App\Http\Controllers\AdminController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/bulk-status', [App\Http\Controllers\AdminController::class, 'bulkUpdateStatus'])->name('orders.bulk-status');
    Route::post('/orders/{id}/tracking', [App\Http\Controllers\AdminController::class, 'updateTracking'])->name('orders.tracking');
    Route::get('/orders/{id}/invoice', [App\Http\Controllers\AdminController::class, 'generateInvoice'])->name('orders.invoice');
    Route::post('/orders/bulk-invoices', [App\Http\Controllers\AdminController::class, 'bulkInvoices'])->name('orders.bulk-invoices');
    Route::get('/orders/{id}/label', [App\Http\Controllers\AdminController::class, 'generateLabel'])->name('orders.label');
    Route::post('/orders/bulk-labels', [App\Http\Controllers\AdminController::class, 'bulkLabels'])->name('orders.bulk-labels');

    Route::post('/products/stock', [App\Http\Controllers\AdminController::class, 'updateStock'])->name('products.stock');

    // ─── Inventory Management ───
    Route::get('/inventory', [App\Http\Controllers\AdminController::class, 'inventory'])->name('inventory');
    Route::post('/inventory/import-csv', [App\Http\Controllers\AdminController::class, 'importInventoryCSV'])->name('inventory.import-csv');

    // ─── Customer Management ───
    Route::get('/customers', [App\Http\Controllers\AdminController::class, 'customers'])->name('customers');
    Route::post('/customers/{id}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleCustomerStatus'])->name('customers.toggle-status');

    // ─── Category Management ───
    Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.delete');

    // ─── Coupon Management ───
    Route::get('/coupons', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupons');
    Route::post('/coupons', [App\Http\Controllers\Admin\CouponController::class, 'store'])->name('coupons.store');
    Route::put('/coupons/{id}', [App\Http\Controllers\Admin\CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{id}', [App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('coupons.delete');
    Route::post('/coupons/{id}/toggle', [App\Http\Controllers\Admin\CouponController::class, 'toggle'])->name('coupons.toggle');

    Route::get('/returns', [App\Http\Controllers\AdminController::class, 'returns'])->name('returns');
    Route::post('/returns/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveReturn'])->name('returns.approve');
    Route::post('/returns/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectReturn'])->name('returns.reject');
    Route::post('/returns/{id}/refund', [App\Http\Controllers\AdminController::class, 'processRefund'])->name('returns.refund');

    Route::get('/tickets', [App\Http\Controllers\AdminController::class, 'tickets'])->name('tickets');
    Route::get('/tickets/{id}', [App\Http\Controllers\AdminController::class, 'ticketShow'])->name('tickets.show');
    Route::post('/tickets/{id}/reply', [App\Http\Controllers\AdminController::class, 'ticketReply'])->name('tickets.reply');
    Route::post('/tickets/{id}/close', [App\Http\Controllers\AdminController::class, 'ticketClose'])->name('tickets.close');
    Route::post('/tickets/{id}/assign', [App\Http\Controllers\AdminController::class, 'ticketAssign'])->name('tickets.assign');

    Route::get('/reviews', [App\Http\Controllers\AdminController::class, 'reviews'])->name('reviews');
    Route::post('/reviews/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveReview'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectReview'])->name('reviews.reject');

    Route::get('/settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\AdminController::class, 'updateSettings'])->name('settings.update');

    // ─── Abandoned Carts Management ───
    Route::get('/abandoned-carts', [App\Http\Controllers\AdminController::class, 'abandonedCarts'])->name('abandoned-carts');
    Route::delete('/abandoned-carts/{id}', [App\Http\Controllers\AdminController::class, 'deleteAbandonedCart'])->name('abandoned-carts.delete');
    Route::post('/abandoned-carts/bulk-delete', [App\Http\Controllers\AdminController::class, 'bulkDeleteAbandonedCarts'])->name('abandoned-carts.bulk-delete');

    // ─── Media Library Management ───
    Route::get('/media', [App\Http\Controllers\Admin\MediaLibraryController::class, 'index'])->name('media');
    Route::post('/media', [App\Http\Controllers\Admin\MediaLibraryController::class, 'store'])->name('media.store');
    Route::post('/media/bulk-delete', [App\Http\Controllers\Admin\MediaLibraryController::class, 'bulkDestroy'])->name('media.bulk-delete');
    Route::delete('/media/{id}', [App\Http\Controllers\Admin\MediaLibraryController::class, 'destroy'])->name('media.delete');
    Route::get('/api/media', [App\Http\Controllers\Admin\MediaLibraryController::class, 'apiIndex'])->name('media.api');
    Route::get('/api/notifications', [App\Http\Controllers\AdminController::class, 'apiNotifications'])->name('notifications.api');

    Route::get('/backups', [App\Http\Controllers\BackupController::class, 'index'])->name('backups');
    Route::post('/backups/create', [App\Http\Controllers\BackupController::class, 'create'])->name('backups.create');
    Route::get('/backups/download/{filename}', [App\Http\Controllers\BackupController::class, 'download'])->name('backups.download');
    Route::post('/backups/restore', [App\Http\Controllers\BackupController::class, 'restore'])->name('backups.restore');
    Route::delete('/backups/delete/{filename}', [App\Http\Controllers\BackupController::class, 'delete'])->name('backups.delete');
});
