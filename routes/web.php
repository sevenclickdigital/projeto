<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\QrbilderController;
use App\Http\Controllers\BranchHourController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SocialLeadController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ScratchCardController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ScratchCardPlayerController;
use App\Http\Controllers\ScratchCardAnswerController;
use App\Http\Controllers\ScratchCardConfigController;
use App\Http\Controllers\HolidayDescriptionController;
use App\Http\Controllers\RatingGoogleBusinessController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('billings', BillingController::class);
        Route::resource('birthdays', BirthdayController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('branch-hours', BranchHourController::class);
        Route::resource('category-products', CategoryProductController::class);
        Route::resource('coupons', CouponController::class);
        Route::resource(
            'holiday-descriptions',
            HolidayDescriptionController::class
        );
        Route::resource('holidays', HolidayController::class);
        Route::resource('leads', LeadController::class);
        Route::resource('messages', MessageController::class);
        Route::resource('newsletters', NewsletterController::class);
        Route::resource('products', ProductController::class);
        Route::resource('qrbilders', QrbilderController::class);
        Route::resource('ratings', RatingController::class);
        Route::resource('users', UserController::class);
        Route::resource('tenants', TenantController::class);
        Route::resource(
            'scratch-card-players',
            ScratchCardPlayerController::class
        );
        Route::resource(
            'scratch-card-answers',
            ScratchCardAnswerController::class
        );
        Route::resource('social-leads', SocialLeadController::class);
        Route::resource(
            'scratch-card-configs',
            ScratchCardConfigController::class
        );
        Route::resource('scratch-cards', ScratchCardController::class);
        Route::resource(
            'rating-google-businesses',
            RatingGoogleBusinessController::class
        );
    });
