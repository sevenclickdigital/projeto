<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\BillingController;
use App\Http\Controllers\Api\HolidayController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BirthdayController;
use App\Http\Controllers\Api\QrbilderController;
use App\Http\Controllers\Api\BranchHourController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\SocialLeadController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\BranchLeadsController;
use App\Http\Controllers\Api\TenantLeadsController;
use App\Http\Controllers\Api\ScratchCardController;
use App\Http\Controllers\Api\LeadBranchesController;
use App\Http\Controllers\Api\BranchRatingsController;
use App\Http\Controllers\Api\BranchCouponsController;
use App\Http\Controllers\Api\TenantRatingsController;
use App\Http\Controllers\Api\TenantCouponsController;
use App\Http\Controllers\Api\BranchProductsController;
use App\Http\Controllers\Api\CouponBranchesController;
use App\Http\Controllers\Api\RatingBranchesController;
use App\Http\Controllers\Api\TenantBillingsController;
use App\Http\Controllers\Api\TenantBranchesController;
use App\Http\Controllers\Api\TenantProductsController;
use App\Http\Controllers\Api\TenantHolidaysController;
use App\Http\Controllers\Api\TenantMessagesController;
use App\Http\Controllers\Api\BranchBirthdaysController;
use App\Http\Controllers\Api\BranchQrbildersController;
use App\Http\Controllers\Api\CategoryProductController;
use App\Http\Controllers\Api\LeadSocialLeadsController;
use App\Http\Controllers\Api\ProductBranchesController;
use App\Http\Controllers\Api\TenantQrbildersController;
use App\Http\Controllers\Api\TenantBirthdaysController;
use App\Http\Controllers\Api\BirthdayBranchesController;
use App\Http\Controllers\Api\QrbilderBranchesController;
use App\Http\Controllers\Api\BranchBranchHoursController;
use App\Http\Controllers\Api\BranchNewslettersController;
use App\Http\Controllers\Api\TenantNewslettersController;
use App\Http\Controllers\Api\TenantSocialLeadsController;
use App\Http\Controllers\Api\TenantBranchHoursController;
use App\Http\Controllers\Api\ScratchCardPlayerController;
use App\Http\Controllers\Api\ScratchCardAnswerController;
use App\Http\Controllers\Api\ScratchCardConfigController;
use App\Http\Controllers\Api\BranchScratchCardsController;
use App\Http\Controllers\Api\HolidayDescriptionController;
use App\Http\Controllers\Api\NewsletterBranchesController;
use App\Http\Controllers\Api\TenantScratchCardsController;
use App\Http\Controllers\Api\SocialLeadMessagesController;
use App\Http\Controllers\Api\ScratchCardBranchesController;
use App\Http\Controllers\Api\RatingGoogleBusinessController;
use App\Http\Controllers\Api\BranchCategoryProductsController;
use App\Http\Controllers\Api\LeadScratchCardPlayersController;
use App\Http\Controllers\Api\TenantCategoryProductsController;
use App\Http\Controllers\Api\CategoryProductProductsController;
use App\Http\Controllers\Api\CategoryProductBranchesController;
use App\Http\Controllers\Api\BranchScratchCardConfigsController;
use App\Http\Controllers\Api\TenantScratchCardConfigsController;
use App\Http\Controllers\Api\TenantScratchCardPlayersController;
use App\Http\Controllers\Api\BranchHolidayDescriptionsController;
use App\Http\Controllers\Api\TenantHolidayDescriptionsController;
use App\Http\Controllers\Api\ScratchCardConfigBranchesController;
use App\Http\Controllers\Api\HolidayDescriptionBranchesController;
use App\Http\Controllers\Api\HolidayHolidayDescriptionsController;
use App\Http\Controllers\Api\BranchRatingGoogleBusinessesController;
use App\Http\Controllers\Api\TenantRatingGoogleBusinessesController;
use App\Http\Controllers\Api\RatingGoogleBusinessBranchesController;
use App\Http\Controllers\Api\ScratchCardScratchCardPlayersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('billings', BillingController::class);

        Route::apiResource('birthdays', BirthdayController::class);

        // Birthday Branches
        Route::get('/birthdays/{birthday}/branches', [
            BirthdayBranchesController::class,
            'index',
        ])->name('birthdays.branches.index');
        Route::post('/birthdays/{birthday}/branches/{branch}', [
            BirthdayBranchesController::class,
            'store',
        ])->name('birthdays.branches.store');
        Route::delete('/birthdays/{birthday}/branches/{branch}', [
            BirthdayBranchesController::class,
            'destroy',
        ])->name('birthdays.branches.destroy');

        Route::apiResource('branches', BranchController::class);

        // Branch Branch Hours
        Route::get('/branches/{branch}/branch-hours', [
            BranchBranchHoursController::class,
            'index',
        ])->name('branches.branch-hours.index');
        Route::post('/branches/{branch}/branch-hours', [
            BranchBranchHoursController::class,
            'store',
        ])->name('branches.branch-hours.store');

        // Branch Leads
        Route::get('/branches/{branch}/leads', [
            BranchLeadsController::class,
            'index',
        ])->name('branches.leads.index');
        Route::post('/branches/{branch}/leads/{lead}', [
            BranchLeadsController::class,
            'store',
        ])->name('branches.leads.store');
        Route::delete('/branches/{branch}/leads/{lead}', [
            BranchLeadsController::class,
            'destroy',
        ])->name('branches.leads.destroy');

        // Branch Scratch Cards
        Route::get('/branches/{branch}/scratch-cards', [
            BranchScratchCardsController::class,
            'index',
        ])->name('branches.scratch-cards.index');
        Route::post('/branches/{branch}/scratch-cards/{scratchCard}', [
            BranchScratchCardsController::class,
            'store',
        ])->name('branches.scratch-cards.store');
        Route::delete('/branches/{branch}/scratch-cards/{scratchCard}', [
            BranchScratchCardsController::class,
            'destroy',
        ])->name('branches.scratch-cards.destroy');

        // Branch Newsletters
        Route::get('/branches/{branch}/newsletters', [
            BranchNewslettersController::class,
            'index',
        ])->name('branches.newsletters.index');
        Route::post('/branches/{branch}/newsletters/{newsletter}', [
            BranchNewslettersController::class,
            'store',
        ])->name('branches.newsletters.store');
        Route::delete('/branches/{branch}/newsletters/{newsletter}', [
            BranchNewslettersController::class,
            'destroy',
        ])->name('branches.newsletters.destroy');

        // Branch Ratings
        Route::get('/branches/{branch}/ratings', [
            BranchRatingsController::class,
            'index',
        ])->name('branches.ratings.index');
        Route::post('/branches/{branch}/ratings/{rating}', [
            BranchRatingsController::class,
            'store',
        ])->name('branches.ratings.store');
        Route::delete('/branches/{branch}/ratings/{rating}', [
            BranchRatingsController::class,
            'destroy',
        ])->name('branches.ratings.destroy');

        // Branch Coupons
        Route::get('/branches/{branch}/coupons', [
            BranchCouponsController::class,
            'index',
        ])->name('branches.coupons.index');
        Route::post('/branches/{branch}/coupons/{coupon}', [
            BranchCouponsController::class,
            'store',
        ])->name('branches.coupons.store');
        Route::delete('/branches/{branch}/coupons/{coupon}', [
            BranchCouponsController::class,
            'destroy',
        ])->name('branches.coupons.destroy');

        // Branch Products
        Route::get('/branches/{branch}/products', [
            BranchProductsController::class,
            'index',
        ])->name('branches.products.index');
        Route::post('/branches/{branch}/products/{product}', [
            BranchProductsController::class,
            'store',
        ])->name('branches.products.store');
        Route::delete('/branches/{branch}/products/{product}', [
            BranchProductsController::class,
            'destroy',
        ])->name('branches.products.destroy');

        // Branch Birthdays
        Route::get('/branches/{branch}/birthdays', [
            BranchBirthdaysController::class,
            'index',
        ])->name('branches.birthdays.index');
        Route::post('/branches/{branch}/birthdays/{birthday}', [
            BranchBirthdaysController::class,
            'store',
        ])->name('branches.birthdays.store');
        Route::delete('/branches/{branch}/birthdays/{birthday}', [
            BranchBirthdaysController::class,
            'destroy',
        ])->name('branches.birthdays.destroy');

        // Branch Rating Google Businesses
        Route::get('/branches/{branch}/rating-google-businesses', [
            BranchRatingGoogleBusinessesController::class,
            'index',
        ])->name('branches.rating-google-businesses.index');
        Route::post(
            '/branches/{branch}/rating-google-businesses/{ratingGoogleBusiness}',
            [BranchRatingGoogleBusinessesController::class, 'store']
        )->name('branches.rating-google-businesses.store');
        Route::delete(
            '/branches/{branch}/rating-google-businesses/{ratingGoogleBusiness}',
            [BranchRatingGoogleBusinessesController::class, 'destroy']
        )->name('branches.rating-google-businesses.destroy');

        // Branch Category Products
        Route::get('/branches/{branch}/category-products', [
            BranchCategoryProductsController::class,
            'index',
        ])->name('branches.category-products.index');
        Route::post('/branches/{branch}/category-products/{categoryProduct}', [
            BranchCategoryProductsController::class,
            'store',
        ])->name('branches.category-products.store');
        Route::delete(
            '/branches/{branch}/category-products/{categoryProduct}',
            [BranchCategoryProductsController::class, 'destroy']
        )->name('branches.category-products.destroy');

        // Branch Holiday Descriptions
        Route::get('/branches/{branch}/holiday-descriptions', [
            BranchHolidayDescriptionsController::class,
            'index',
        ])->name('branches.holiday-descriptions.index');
        Route::post(
            '/branches/{branch}/holiday-descriptions/{holidayDescription}',
            [BranchHolidayDescriptionsController::class, 'store']
        )->name('branches.holiday-descriptions.store');
        Route::delete(
            '/branches/{branch}/holiday-descriptions/{holidayDescription}',
            [BranchHolidayDescriptionsController::class, 'destroy']
        )->name('branches.holiday-descriptions.destroy');

        // Branch Qrbilders
        Route::get('/branches/{branch}/qrbilders', [
            BranchQrbildersController::class,
            'index',
        ])->name('branches.qrbilders.index');
        Route::post('/branches/{branch}/qrbilders/{qrbilder}', [
            BranchQrbildersController::class,
            'store',
        ])->name('branches.qrbilders.store');
        Route::delete('/branches/{branch}/qrbilders/{qrbilder}', [
            BranchQrbildersController::class,
            'destroy',
        ])->name('branches.qrbilders.destroy');

        // Branch Scratch Card Configs
        Route::get('/branches/{branch}/scratch-card-configs', [
            BranchScratchCardConfigsController::class,
            'index',
        ])->name('branches.scratch-card-configs.index');
        Route::post(
            '/branches/{branch}/scratch-card-configs/{scratchCardConfig}',
            [BranchScratchCardConfigsController::class, 'store']
        )->name('branches.scratch-card-configs.store');
        Route::delete(
            '/branches/{branch}/scratch-card-configs/{scratchCardConfig}',
            [BranchScratchCardConfigsController::class, 'destroy']
        )->name('branches.scratch-card-configs.destroy');

        Route::apiResource('branch-hours', BranchHourController::class);

        Route::apiResource(
            'category-products',
            CategoryProductController::class
        );

        // CategoryProduct Products
        Route::get('/category-products/{categoryProduct}/products', [
            CategoryProductProductsController::class,
            'index',
        ])->name('category-products.products.index');
        Route::post('/category-products/{categoryProduct}/products', [
            CategoryProductProductsController::class,
            'store',
        ])->name('category-products.products.store');

        // CategoryProduct Branches
        Route::get('/category-products/{categoryProduct}/branches', [
            CategoryProductBranchesController::class,
            'index',
        ])->name('category-products.branches.index');
        Route::post('/category-products/{categoryProduct}/branches/{branch}', [
            CategoryProductBranchesController::class,
            'store',
        ])->name('category-products.branches.store');
        Route::delete(
            '/category-products/{categoryProduct}/branches/{branch}',
            [CategoryProductBranchesController::class, 'destroy']
        )->name('category-products.branches.destroy');

        Route::apiResource('coupons', CouponController::class);

        // Coupon Branches
        Route::get('/coupons/{coupon}/branches', [
            CouponBranchesController::class,
            'index',
        ])->name('coupons.branches.index');
        Route::post('/coupons/{coupon}/branches/{branch}', [
            CouponBranchesController::class,
            'store',
        ])->name('coupons.branches.store');
        Route::delete('/coupons/{coupon}/branches/{branch}', [
            CouponBranchesController::class,
            'destroy',
        ])->name('coupons.branches.destroy');

        Route::apiResource(
            'holiday-descriptions',
            HolidayDescriptionController::class
        );

        // HolidayDescription Branches
        Route::get('/holiday-descriptions/{holidayDescription}/branches', [
            HolidayDescriptionBranchesController::class,
            'index',
        ])->name('holiday-descriptions.branches.index');
        Route::post(
            '/holiday-descriptions/{holidayDescription}/branches/{branch}',
            [HolidayDescriptionBranchesController::class, 'store']
        )->name('holiday-descriptions.branches.store');
        Route::delete(
            '/holiday-descriptions/{holidayDescription}/branches/{branch}',
            [HolidayDescriptionBranchesController::class, 'destroy']
        )->name('holiday-descriptions.branches.destroy');

        Route::apiResource('holidays', HolidayController::class);

        // Holiday Holiday Descriptions
        Route::get('/holidays/{holiday}/holiday-descriptions', [
            HolidayHolidayDescriptionsController::class,
            'index',
        ])->name('holidays.holiday-descriptions.index');
        Route::post('/holidays/{holiday}/holiday-descriptions', [
            HolidayHolidayDescriptionsController::class,
            'store',
        ])->name('holidays.holiday-descriptions.store');

        Route::apiResource('leads', LeadController::class);

        // Lead Social Leads
        Route::get('/leads/{lead}/social-leads', [
            LeadSocialLeadsController::class,
            'index',
        ])->name('leads.social-leads.index');
        Route::post('/leads/{lead}/social-leads', [
            LeadSocialLeadsController::class,
            'store',
        ])->name('leads.social-leads.store');

        // Lead Scratch Card Players
        Route::get('/leads/{lead}/scratch-card-players', [
            LeadScratchCardPlayersController::class,
            'index',
        ])->name('leads.scratch-card-players.index');
        Route::post('/leads/{lead}/scratch-card-players', [
            LeadScratchCardPlayersController::class,
            'store',
        ])->name('leads.scratch-card-players.store');

        // Lead Branches
        Route::get('/leads/{lead}/branches', [
            LeadBranchesController::class,
            'index',
        ])->name('leads.branches.index');
        Route::post('/leads/{lead}/branches/{branch}', [
            LeadBranchesController::class,
            'store',
        ])->name('leads.branches.store');
        Route::delete('/leads/{lead}/branches/{branch}', [
            LeadBranchesController::class,
            'destroy',
        ])->name('leads.branches.destroy');

        Route::apiResource('messages', MessageController::class);

        Route::apiResource('newsletters', NewsletterController::class);

        // Newsletter Branches
        Route::get('/newsletters/{newsletter}/branches', [
            NewsletterBranchesController::class,
            'index',
        ])->name('newsletters.branches.index');
        Route::post('/newsletters/{newsletter}/branches/{branch}', [
            NewsletterBranchesController::class,
            'store',
        ])->name('newsletters.branches.store');
        Route::delete('/newsletters/{newsletter}/branches/{branch}', [
            NewsletterBranchesController::class,
            'destroy',
        ])->name('newsletters.branches.destroy');

        Route::apiResource('products', ProductController::class);

        // Product Branches
        Route::get('/products/{product}/branches', [
            ProductBranchesController::class,
            'index',
        ])->name('products.branches.index');
        Route::post('/products/{product}/branches/{branch}', [
            ProductBranchesController::class,
            'store',
        ])->name('products.branches.store');
        Route::delete('/products/{product}/branches/{branch}', [
            ProductBranchesController::class,
            'destroy',
        ])->name('products.branches.destroy');

        Route::apiResource('qrbilders', QrbilderController::class);

        // Qrbilder Branches
        Route::get('/qrbilders/{qrbilder}/branches', [
            QrbilderBranchesController::class,
            'index',
        ])->name('qrbilders.branches.index');
        Route::post('/qrbilders/{qrbilder}/branches/{branch}', [
            QrbilderBranchesController::class,
            'store',
        ])->name('qrbilders.branches.store');
        Route::delete('/qrbilders/{qrbilder}/branches/{branch}', [
            QrbilderBranchesController::class,
            'destroy',
        ])->name('qrbilders.branches.destroy');

        Route::apiResource('ratings', RatingController::class);

        // Rating Branches
        Route::get('/ratings/{rating}/branches', [
            RatingBranchesController::class,
            'index',
        ])->name('ratings.branches.index');
        Route::post('/ratings/{rating}/branches/{branch}', [
            RatingBranchesController::class,
            'store',
        ])->name('ratings.branches.store');
        Route::delete('/ratings/{rating}/branches/{branch}', [
            RatingBranchesController::class,
            'destroy',
        ])->name('ratings.branches.destroy');

        Route::apiResource('users', UserController::class);

        Route::apiResource('tenants', TenantController::class);

        // Tenant Billings
        Route::get('/tenants/{tenant}/billings', [
            TenantBillingsController::class,
            'index',
        ])->name('tenants.billings.index');
        Route::post('/tenants/{tenant}/billings', [
            TenantBillingsController::class,
            'store',
        ])->name('tenants.billings.store');

        // Tenant Branches
        Route::get('/tenants/{tenant}/branches', [
            TenantBranchesController::class,
            'index',
        ])->name('tenants.branches.index');
        Route::post('/tenants/{tenant}/branches', [
            TenantBranchesController::class,
            'store',
        ])->name('tenants.branches.store');

        // Tenant Scratch Cards
        Route::get('/tenants/{tenant}/scratch-cards', [
            TenantScratchCardsController::class,
            'index',
        ])->name('tenants.scratch-cards.index');
        Route::post('/tenants/{tenant}/scratch-cards', [
            TenantScratchCardsController::class,
            'store',
        ])->name('tenants.scratch-cards.store');

        // Tenant Newsletters
        Route::get('/tenants/{tenant}/newsletters', [
            TenantNewslettersController::class,
            'index',
        ])->name('tenants.newsletters.index');
        Route::post('/tenants/{tenant}/newsletters', [
            TenantNewslettersController::class,
            'store',
        ])->name('tenants.newsletters.store');

        // Tenant Ratings
        Route::get('/tenants/{tenant}/ratings', [
            TenantRatingsController::class,
            'index',
        ])->name('tenants.ratings.index');
        Route::post('/tenants/{tenant}/ratings', [
            TenantRatingsController::class,
            'store',
        ])->name('tenants.ratings.store');

        // Tenant Coupons
        Route::get('/tenants/{tenant}/coupons', [
            TenantCouponsController::class,
            'index',
        ])->name('tenants.coupons.index');
        Route::post('/tenants/{tenant}/coupons', [
            TenantCouponsController::class,
            'store',
        ])->name('tenants.coupons.store');

        // Tenant Products
        Route::get('/tenants/{tenant}/products', [
            TenantProductsController::class,
            'index',
        ])->name('tenants.products.index');
        Route::post('/tenants/{tenant}/products', [
            TenantProductsController::class,
            'store',
        ])->name('tenants.products.store');

        // Tenant Qrbilders
        Route::get('/tenants/{tenant}/qrbilders', [
            TenantQrbildersController::class,
            'index',
        ])->name('tenants.qrbilders.index');
        Route::post('/tenants/{tenant}/qrbilders', [
            TenantQrbildersController::class,
            'store',
        ])->name('tenants.qrbilders.store');

        // Tenant Holidays
        Route::get('/tenants/{tenant}/holidays', [
            TenantHolidaysController::class,
            'index',
        ])->name('tenants.holidays.index');
        Route::post('/tenants/{tenant}/holidays', [
            TenantHolidaysController::class,
            'store',
        ])->name('tenants.holidays.store');

        // Tenant Category Products
        Route::get('/tenants/{tenant}/category-products', [
            TenantCategoryProductsController::class,
            'index',
        ])->name('tenants.category-products.index');
        Route::post('/tenants/{tenant}/category-products', [
            TenantCategoryProductsController::class,
            'store',
        ])->name('tenants.category-products.store');

        // Tenant Scratch Card Configs
        Route::get('/tenants/{tenant}/scratch-card-configs', [
            TenantScratchCardConfigsController::class,
            'index',
        ])->name('tenants.scratch-card-configs.index');
        Route::post('/tenants/{tenant}/scratch-card-configs', [
            TenantScratchCardConfigsController::class,
            'store',
        ])->name('tenants.scratch-card-configs.store');

        // Tenant Scratch Card Players
        Route::get('/tenants/{tenant}/scratch-card-players', [
            TenantScratchCardPlayersController::class,
            'index',
        ])->name('tenants.scratch-card-players.index');
        Route::post('/tenants/{tenant}/scratch-card-players', [
            TenantScratchCardPlayersController::class,
            'store',
        ])->name('tenants.scratch-card-players.store');

        // Tenant Leads
        Route::get('/tenants/{tenant}/leads', [
            TenantLeadsController::class,
            'index',
        ])->name('tenants.leads.index');
        Route::post('/tenants/{tenant}/leads', [
            TenantLeadsController::class,
            'store',
        ])->name('tenants.leads.store');

        // Tenant Social Leads
        Route::get('/tenants/{tenant}/social-leads', [
            TenantSocialLeadsController::class,
            'index',
        ])->name('tenants.social-leads.index');
        Route::post('/tenants/{tenant}/social-leads', [
            TenantSocialLeadsController::class,
            'store',
        ])->name('tenants.social-leads.store');

        // Tenant Messages
        Route::get('/tenants/{tenant}/messages', [
            TenantMessagesController::class,
            'index',
        ])->name('tenants.messages.index');
        Route::post('/tenants/{tenant}/messages', [
            TenantMessagesController::class,
            'store',
        ])->name('tenants.messages.store');

        // Tenant Rating Google Businesses
        Route::get('/tenants/{tenant}/rating-google-businesses', [
            TenantRatingGoogleBusinessesController::class,
            'index',
        ])->name('tenants.rating-google-businesses.index');
        Route::post('/tenants/{tenant}/rating-google-businesses', [
            TenantRatingGoogleBusinessesController::class,
            'store',
        ])->name('tenants.rating-google-businesses.store');

        // Tenant Branch Hours
        Route::get('/tenants/{tenant}/branch-hours', [
            TenantBranchHoursController::class,
            'index',
        ])->name('tenants.branch-hours.index');
        Route::post('/tenants/{tenant}/branch-hours', [
            TenantBranchHoursController::class,
            'store',
        ])->name('tenants.branch-hours.store');

        // Tenant Birthdays
        Route::get('/tenants/{tenant}/birthdays', [
            TenantBirthdaysController::class,
            'index',
        ])->name('tenants.birthdays.index');
        Route::post('/tenants/{tenant}/birthdays', [
            TenantBirthdaysController::class,
            'store',
        ])->name('tenants.birthdays.store');

        // Tenant Holiday Descriptions
        Route::get('/tenants/{tenant}/holiday-descriptions', [
            TenantHolidayDescriptionsController::class,
            'index',
        ])->name('tenants.holiday-descriptions.index');
        Route::post('/tenants/{tenant}/holiday-descriptions', [
            TenantHolidayDescriptionsController::class,
            'store',
        ])->name('tenants.holiday-descriptions.store');

        Route::apiResource(
            'scratch-card-players',
            ScratchCardPlayerController::class
        );

        Route::apiResource(
            'scratch-card-answers',
            ScratchCardAnswerController::class
        );

        Route::apiResource('social-leads', SocialLeadController::class);

        // SocialLead Messages
        Route::get('/social-leads/{socialLead}/messages', [
            SocialLeadMessagesController::class,
            'index',
        ])->name('social-leads.messages.index');
        Route::post('/social-leads/{socialLead}/messages', [
            SocialLeadMessagesController::class,
            'store',
        ])->name('social-leads.messages.store');

        Route::apiResource(
            'scratch-card-configs',
            ScratchCardConfigController::class
        );

        // ScratchCardConfig Branches
        Route::get('/scratch-card-configs/{scratchCardConfig}/branches', [
            ScratchCardConfigBranchesController::class,
            'index',
        ])->name('scratch-card-configs.branches.index');
        Route::post(
            '/scratch-card-configs/{scratchCardConfig}/branches/{branch}',
            [ScratchCardConfigBranchesController::class, 'store']
        )->name('scratch-card-configs.branches.store');
        Route::delete(
            '/scratch-card-configs/{scratchCardConfig}/branches/{branch}',
            [ScratchCardConfigBranchesController::class, 'destroy']
        )->name('scratch-card-configs.branches.destroy');

        Route::apiResource('scratch-cards', ScratchCardController::class);

        // ScratchCard Scratch Card Players
        Route::get('/scratch-cards/{scratchCard}/scratch-card-players', [
            ScratchCardScratchCardPlayersController::class,
            'index',
        ])->name('scratch-cards.scratch-card-players.index');
        Route::post('/scratch-cards/{scratchCard}/scratch-card-players', [
            ScratchCardScratchCardPlayersController::class,
            'store',
        ])->name('scratch-cards.scratch-card-players.store');

        // ScratchCard Branches
        Route::get('/scratch-cards/{scratchCard}/branches', [
            ScratchCardBranchesController::class,
            'index',
        ])->name('scratch-cards.branches.index');
        Route::post('/scratch-cards/{scratchCard}/branches/{branch}', [
            ScratchCardBranchesController::class,
            'store',
        ])->name('scratch-cards.branches.store');
        Route::delete('/scratch-cards/{scratchCard}/branches/{branch}', [
            ScratchCardBranchesController::class,
            'destroy',
        ])->name('scratch-cards.branches.destroy');

        Route::apiResource(
            'rating-google-businesses',
            RatingGoogleBusinessController::class
        );

        // RatingGoogleBusiness Branches
        Route::get(
            '/rating-google-businesses/{ratingGoogleBusiness}/branches',
            [RatingGoogleBusinessBranchesController::class, 'index']
        )->name('rating-google-businesses.branches.index');
        Route::post(
            '/rating-google-businesses/{ratingGoogleBusiness}/branches/{branch}',
            [RatingGoogleBusinessBranchesController::class, 'store']
        )->name('rating-google-businesses.branches.store');
        Route::delete(
            '/rating-google-businesses/{ratingGoogleBusiness}/branches/{branch}',
            [RatingGoogleBusinessBranchesController::class, 'destroy']
        )->name('rating-google-businesses.branches.destroy');
    });
