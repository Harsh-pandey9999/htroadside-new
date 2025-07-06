<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\RequestServiceController;
use App\Http\Controllers\JobApplicationsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\WebsiteSettingsController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\BlogCommentController;
use App\Http\Controllers\Admin\ApiSettingController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\OtpPasswordResetController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\Admin\CareerController as AdminCareerController;

// Home & Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Toggle Material Design
Route::get('/toggle-design', [\App\Http\Controllers\MaterialDesignController::class, 'toggleDesign'])->name('toggle.design');
Route::get('/work-with-us', [HomeController::class, 'workWithUs'])->name('work-with-us');
Route::post('/work-with-us', [JobApplicationsController::class, 'store'])->name('job-applications.store');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/cookies', [HomeController::class, 'cookies'])->name('cookies');

// Services Routes
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/request-service', [RequestServiceController::class, 'create'])->name('request-service');
Route::post('/request-service', [RequestServiceController::class, 'store'])->name('request-service.store');

// Plans Routes
Route::get('/plans', [PlansController::class, 'index'])->name('plans.index');
Route::get('/plans/{id}', [PlansController::class, 'show'])->name('plans.show');
Route::post('/plans/{id}/purchase', [PaymentsController::class, 'initiatePurchase'])->name('plans.purchase');
Route::get('/payment/callback', [PaymentsController::class, 'handleCallback'])->name('payment.callback');

// Jobs Routes
Route::get('/jobs', [\App\Http\Controllers\JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [\App\Http\Controllers\JobController::class, 'show'])->name('jobs.show');
Route::get('/jobs/{id}/apply', [\App\Http\Controllers\JobController::class, 'apply'])->name('jobs.apply')->middleware(['auth', 'role:customer']);
Route::post('/jobs/{id}/apply', [\App\Http\Controllers\JobController::class, 'storeApplication'])->name('jobs.apply.store')->middleware(['auth', 'role:customer']);

// Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/search', [BlogController::class, 'search'])->name('search');
    Route::get('/category/{slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('tag');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
    Route::post('/{postSlug}/comment', [BlogController::class, 'storeComment'])->name('comment.store');
});

// Newsletter Routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'confirmUnsubscribe'])->name('newsletter.confirm-unsubscribe');
Route::post('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Feedback Route
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    
    // OTP Login
    Route::get('/login/otp', [\App\Http\Controllers\Auth\LoginController::class, 'showOtpLoginForm'])->name('login.otp');
    Route::post('/login/otp/send', [\App\Http\Controllers\Auth\LoginController::class, 'sendLoginOtp'])->name('login.otp.send')->middleware('throttle:3,1'); // Limit to 3 attempts per minute
    Route::get('/login/otp/verify', [\App\Http\Controllers\Auth\LoginController::class, 'showOtpVerificationForm'])->name('login.otp.verify');
    Route::post('/login/otp/verify', [\App\Http\Controllers\Auth\LoginController::class, 'verifyLoginOtp'])->name('login.otp.verify.submit')->middleware('throttle:5,1'); // Limit to 5 attempts per minute
    Route::get('/login/otp/resend', [\App\Http\Controllers\Auth\LoginController::class, 'resendLoginOtp'])->name('login.otp.resend')->middleware('throttle:2,1'); // Limit to 2 attempts per minute
    
    // Customer Registration
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
    Route::get('/user/verify-otp', [\App\Http\Controllers\Auth\RegisterController::class, 'showOtpVerificationForm'])->name('user.verify.otp');
    Route::post('/user/verify-otp', [\App\Http\Controllers\Auth\RegisterController::class, 'verifyOtp'])->name('user.verify.otp.submit')->middleware('throttle:5,1'); // Limit to 5 attempts per minute
    Route::get('/user/resend-otp', [\App\Http\Controllers\Auth\RegisterController::class, 'resendOtp'])->name('user.verify.otp.resend')->middleware('throttle:2,1'); // Limit to 2 attempts per minute
    
    // Vendor Registration
    Route::get('/vendor/register', [\App\Http\Controllers\Auth\VendorRegisterController::class, 'showRegistrationForm'])->name('vendor.register');
    Route::post('/vendor/register', [\App\Http\Controllers\Auth\VendorRegisterController::class, 'register']);
    
    // Password Reset
    Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
    
    // OTP-based Password Reset
    Route::get('/password/otp', [\App\Http\Controllers\Auth\OtpPasswordResetController::class, 'showRequestForm'])->name('password.otp.request');
    Route::post('/password/otp/send', [\App\Http\Controllers\Auth\OtpPasswordResetController::class, 'sendOtp'])->name('password.otp.send')->middleware('throttle:3,1'); // Limit to 3 attempts per minute
    Route::get('/password/otp/verify', [\App\Http\Controllers\Auth\OtpPasswordResetController::class, 'showResetForm'])->name('password.otp.verify');
    Route::post('/password/otp/reset', [\App\Http\Controllers\Auth\OtpPasswordResetController::class, 'resetPassword'])->name('password.otp.reset')->middleware('throttle:5,1'); // Limit to 5 attempts per minute
    Route::get('/password/otp/resend', [\App\Http\Controllers\Auth\OtpPasswordResetController::class, 'resendOtp'])->name('password.otp.resend')->middleware('throttle:2,1'); // Limit to 2 attempts per minute
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Admin Login Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes for admin login
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('login.submit');
    });
    
    // Admin logout route
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('logout');
    });
    
    // Protected Admin Routes - using our custom middleware to ensure only admins can access
    Route::middleware([\App\Http\Middleware\RedirectIfNotAdmin::class])->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Admin Profile
        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.update-password');
        Route::put('/profile/notifications', [\App\Http\Controllers\Admin\ProfileController::class, 'updateNotifications'])->name('profile.update-notifications');
        Route::post('/profile/logout-other-devices', [\App\Http\Controllers\Admin\ProfileController::class, 'logoutOtherDevices'])->name('profile.logout-other-devices');
    
        // Job Management
        Route::resource('jobs', \App\Http\Controllers\Admin\JobController::class);
        Route::get('jobs/{job}/applications', [\App\Http\Controllers\Admin\JobController::class, 'applications'])->name('jobs.applications');
        Route::post('jobs/{job}/toggle-active', [\App\Http\Controllers\Admin\JobController::class, 'toggleActive'])->name('jobs.toggle-active');
        Route::post('jobs/{job}/toggle-featured', [\App\Http\Controllers\Admin\JobController::class, 'toggleFeatured'])->name('jobs.toggle-featured');
    
        // Services Management
        Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    
        // Plans Management
        Route::resource('plans', \App\Http\Controllers\Admin\PlanController::class);
    
        // Service Requests Management
        Route::resource('service-requests', \App\Http\Controllers\Admin\ServiceRequestController::class);
        Route::post('service-requests/{id}/status', [\App\Http\Controllers\Admin\ServiceRequestController::class, 'updateStatus'])->name('service-requests.update-status');
    
        // User Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
        // Job Applications
        Route::resource('job-applications', \App\Http\Controllers\Admin\JobApplicationController::class)->only(['index', 'show', 'destroy']);
        Route::post('job-applications/{id}/status', [\App\Http\Controllers\Admin\JobApplicationController::class, 'updateStatus'])->name('job-applications.update-status');
    
        // Payments
        Route::get('payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show');
    
        // Website Settings
        Route::get('settings', [WebsiteSettingsController::class, 'edit'])->name('settings.edit');
        Route::post('settings', [WebsiteSettingsController::class, 'update'])->name('settings.update');
    
        // Blog Management
        Route::resource('blog/posts', BlogPostController::class);
        Route::resource('blog/categories', BlogCategoryController::class);
        Route::resource('blog/tags', BlogTagController::class);
    
        // Blog Comments
        Route::get('blog/comments', [BlogCommentController::class, 'index'])->name('blog.comments.index');
        Route::get('blog/comments/{comment}', [BlogCommentController::class, 'show'])->name('blog.comments.show');
        Route::post('blog/comments/{comment}/approve', [BlogCommentController::class, 'approve'])->name('blog.comments.approve');
        Route::delete('blog/comments/{comment}', [BlogCommentController::class, 'destroy'])->name('blog.comments.destroy');
    
        // API Settings
        Route::get('api-settings', [ApiSettingController::class, 'index'])->name('api-settings.index');
        Route::post('api-settings/razorpay', [ApiSettingController::class, 'updateRazorpay'])->name('api-settings.razorpay');
        Route::post('api-settings/fast2sms', [ApiSettingController::class, 'updateFast2sms'])->name('api-settings.fast2sms');
    
        // Reports
        Route::get('reports/sales', [\App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/service-requests', [\App\Http\Controllers\Admin\ReportController::class, 'serviceRequests'])->name('reports.service-requests');
    });
});

// OTP Verification Routes
Route::post('/otp/send', [OtpVerificationController::class, 'sendOtp'])->name('otp.send')->middleware('throttle:3,1'); // Limit to 3 attempts per minute
Route::post('/otp/verify', [OtpVerificationController::class, 'verifyOtp'])->name('otp.verify')->middleware('throttle:5,1'); // Limit to 5 attempts per minute
Route::post('/otp/resend', [OtpVerificationController::class, 'resendOtp'])->name('otp.resend')->middleware('throttle:2,1'); // Limit to 2 attempts per minute

// Vendor Registration OTP Verification
Route::get('/vendor/verify-otp', [\App\Http\Controllers\Auth\VendorRegisterController::class, 'showOtpVerificationForm'])->name('vendor.verify.otp');
Route::post('/vendor/verify-otp', [\App\Http\Controllers\Auth\VendorRegisterController::class, 'verifyOtp'])->name('vendor.verify.otp.submit')->middleware('throttle:5,1'); // Limit to 5 attempts per minute
Route::get('/vendor/resend-otp', [\App\Http\Controllers\Auth\VendorRegisterController::class, 'resendOtp'])->name('vendor.verify.otp.resend')->middleware('throttle:2,1'); // Limit to 2 attempts per minute

// Service Provider Routes
Route::prefix('provider')->name('provider.')->middleware(['auth', 'role:service_provider'])->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Provider\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [\App\Http\Controllers\Provider\DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/notifications', [\App\Http\Controllers\Provider\DashboardController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{id}/mark-as-read', [\App\Http\Controllers\Provider\DashboardController::class, 'markNotificationAsRead'])->name('notifications.mark-as-read');
    
    // Service Requests Management
    Route::get('service-requests', [\App\Http\Controllers\Provider\ServiceRequestController::class, 'index'])->name('service-requests.index');
    Route::get('service-requests/{id}', [\App\Http\Controllers\Provider\ServiceRequestController::class, 'show'])->name('service-requests.show');
    Route::post('service-requests/{id}/accept', [\App\Http\Controllers\Provider\ServiceRequestController::class, 'accept'])->name('service-requests.accept');
    Route::post('service-requests/{id}/complete', [\App\Http\Controllers\Provider\ServiceRequestController::class, 'complete'])->name('service-requests.complete');
    Route::post('service-requests/{id}/cancel', [\App\Http\Controllers\Provider\ServiceRequestController::class, 'cancel'])->name('service-requests.cancel');
    Route::post('service-requests/{id}/update-location', [\App\Http\Controllers\Provider\ServiceRequestController::class, 'updateLocation'])->name('service-requests.update-location');
    Route::post('service-requests/{id}/add-note', [\App\Http\Controllers\Provider\ServiceRequestController::class, 'addNote'])->name('service-requests.add-note');
    
    // Payments
    Route::get('payments', [\App\Http\Controllers\Provider\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{id}', [\App\Http\Controllers\Provider\PaymentController::class, 'show'])->name('payments.show');
    
    // Profile
    Route::get('profile', [\App\Http\Controllers\Provider\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\Provider\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/services', [\App\Http\Controllers\Provider\ProfileController::class, 'updateServices'])->name('profile.services.update');
    Route::put('profile/availability', [\App\Http\Controllers\Provider\ProfileController::class, 'updateAvailability'])->name('profile.availability.update');
    
    // Reviews
    Route::get('reviews', [\App\Http\Controllers\Provider\ReviewController::class, 'index'])->name('reviews.index');
    
    // Job Management
    Route::resource('jobs', \App\Http\Controllers\Provider\JobController::class);
    Route::get('jobs/{job}/applications', [\App\Http\Controllers\Provider\JobController::class, 'applications'])->name('jobs.applications');
    Route::post('jobs/{job}/applications/{application}/status', [\App\Http\Controllers\Provider\JobController::class, 'updateApplicationStatus'])->name('jobs.applications.update-status');
});

// Customer Dashboard Routes
Route::prefix('dashboard')->name('customer.')->middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/activity-history', [\App\Http\Controllers\Customer\DashboardController::class, 'activityHistory'])->name('activity-history');
    Route::get('/notifications', [\App\Http\Controllers\Customer\DashboardController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{id}/mark-as-read', [\App\Http\Controllers\Customer\DashboardController::class, 'markNotificationAsRead'])->name('notifications.mark-as-read');
    Route::get('service-requests', [\App\Http\Controllers\Customer\ServiceRequestController::class, 'index'])->name('service-requests.index');
    Route::get('service-requests/{id}', [\App\Http\Controllers\Customer\ServiceRequestController::class, 'show'])->name('service-requests.show');
    Route::get('payments', [\App\Http\Controllers\Customer\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{id}', [\App\Http\Controllers\Customer\PaymentController::class, 'show'])->name('payments.show');
    Route::get('subscriptions', [\App\Http\Controllers\Customer\SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('emergency-contacts', [\App\Http\Controllers\Customer\EmergencyContactController::class, 'index'])->name('emergency-contacts.index');
    Route::post('emergency-contacts', [\App\Http\Controllers\Customer\EmergencyContactController::class, 'store'])->name('emergency-contacts.store');
    Route::put('emergency-contacts/{id}', [\App\Http\Controllers\Customer\EmergencyContactController::class, 'update'])->name('emergency-contacts.update');
    Route::delete('emergency-contacts/{id}', [\App\Http\Controllers\Customer\EmergencyContactController::class, 'destroy'])->name('emergency-contacts.destroy');
    
    // Job Applications
    Route::get('applications', [\App\Http\Controllers\Customer\JobApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{id}', [\App\Http\Controllers\Customer\JobApplicationController::class, 'show'])->name('applications.show');
    Route::post('applications/{id}/withdraw', [\App\Http\Controllers\Customer\JobApplicationController::class, 'withdraw'])->name('applications.withdraw');
});

// Include Career Routes
try {
    require __DIR__.'/web-careers.php';
} catch (\Exception $e) {
    \Log::error('Error loading career routes: ' . $e->getMessage());
}

