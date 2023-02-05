<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapMemberWebRoutes();
        $this->mapUserWebRoutes();
        $this->mapPageRoutes();
        $this->mapRoleWebRoutes();
        $this->mapMembershipWebRoutes();
        $this->mapAttendanceWebRoutes();
        $this->mapUserProfileMapWebRoutes();
        $this->mapNewsletterMapWebRoutes();
        $this->mapConsultationMapWebRoutes();
        $this->mapExpenseMapWebRoutes();
        $this->mapTagMapWebRoutes();
        $this->mapBrandMapWebRoutes();
        $this->mapUserAttendanceMapWebRoutes();
        $this->mapCategoryMapWebRoutes();
        $this->mapAttributeMapWebRoutes();
        $this->mapValueMapWebRoutes();
        $this->mapProductMapWebRoutes();
        $this->mapDashboardWebRoutes();
        $this->mapLockerWebRoutes();
        $this->mapInstagramFeedsWebRoutes();
        $this->mapFeeLogWebRoutes();
        $this->mapRegLogWebRoutes();
        $this->mapPtfLogWebRoutes();
        $this->mapOrderApiRoutes();
        $this->mapProductApiRoutes();
        $this->mapGoalWebRoutes();
        $this->mapGoalApiRoutes();
        $this->mapCategoryApiRoutes();
        $this->mapOrderWebRoutes();
        $this->mapWishlistApiRoutes();
        $this->mapMembershipApiRoutes();
        $this->mapClassesMapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapMemberWebRoutes()
    {
        Route::prefix('member')
            ->name('member.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/member.php'));
    }

    protected function mapUserWebRoutes()
    {
        Route::prefix('user')
            ->name('user.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/user.php'));
    }

    protected function mapPageRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/views.php'));
    }

    protected function mapRoleWebRoutes()
    {
        Route::prefix('role')
            ->name('role.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/role.php'));
    }

    protected function mapMembershipWebRoutes()
    {
        Route::prefix('membership')
            ->name('membership.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/membership.php'));

    }

    protected function mapAttendanceWebRoutes()
    {
        Route::prefix('attendance')
            ->name('attendance.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/attendance.php'));
    }

    protected function mapUserProfileMapWebRoutes()
    {
        Route::prefix('userprofile')
            ->name('userprofile.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/userprofile.php'));
    }

    protected function mapNewsletterMapWebRoutes()
    {
        Route::prefix('newsletter')
            ->name('newsletter.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/newsletter.php'));
    }

    protected function mapConsultationMapWebRoutes()
    {
        Route::prefix('consultation')
            ->name('consultation.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/consultation.php'));
    }

    protected function mapExpenseMapWebRoutes()
    {
        Route::prefix('expense')
            ->name('expense.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/expense.php'));
    }

    protected function mapTagMapWebRoutes()
    {
        Route::prefix('tag')
            ->name('tag.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/tag.php'));
    }

    protected function mapBrandMapWebRoutes()
    {
        Route::prefix('brand')
            ->name('brand.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/brand.php'));
    }

    public function mapUserAttendanceMapWebRoutes()
    {
        Route::prefix('userattendance')
            ->name('userattendance.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/userattendance.php'));
    }

    protected function mapCategoryMapWebRoutes()
    {
        Route::prefix('category')
            ->name('category.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/category.php'));
    }

    protected function mapAttributeMapWebRoutes()
    {
        Route::prefix('attribute')
            ->name('attribute.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/attribute.php'));
    }

    protected function mapValueMapWebRoutes()
    {
        Route::prefix('value')
            ->name('value.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/value.php'));
    }

    protected function mapProductMapWebRoutes()
    {
        Route::prefix('product')
            ->name('product.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/product.php'));
    }

    protected function mapDashboardWebRoutes()
    {
        Route::prefix('dashboard')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/dashboard.php'));
    }

    protected function mapLockerWebRoutes()
    {
        Route::prefix('locker')
            ->name('locker.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/locker.php'));
    }

    protected function mapInstagramFeedsWebRoutes()
    {
        Route::prefix('instagram')
            ->name('instagram.')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend/instagramfeeds.php'));
    }

    protected function mapFeeLogWebRoutes()
    {
        Route::prefix('feelog')
            ->name('feelog')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/feelog.php'));
    }

    protected function mapRegLogWebRoutes()
    {
        Route::prefix('reglog')
            ->name('reglog')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/reglog.php'));
    }

    protected function mapPtfLogWebRoutes()
    {
        Route::prefix('ptflog')
            ->name('ptflog')
            ->middleware('web', 'auth')
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/ptflog.php'));
    }

    protected function mapOrderApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend/api/orders.php'));
    }

    protected function mapProductApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend/api/products.php'));
    }

    protected function mapGoalWebRoutes()
    {
        Route::prefix('goal')
            ->name('goal.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/goal.php'));
    }

    protected function mapGoalApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend/api/goals.php'));
    }

    protected function mapCategoryApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend/api/categories.php'));
    }

    protected function mapOrderWebRoutes()
    {
        Route::prefix('order')
            ->name('order.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/order.php'));
    }

    protected function mapWishlistApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend/api/wishlist.php'));
    }

    protected function mapMembershipApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend/api/membership.php'));
    }
    protected function mapClassesMapWebRoutes()
    {
        Route::prefix('classes')
            ->name('classes.')
            ->middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/backend/classes.php'));
    }
}
