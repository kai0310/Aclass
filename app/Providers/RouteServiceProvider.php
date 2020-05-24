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
    public const HOME = '/home';

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

        $this->mapWebTaskRoutes();
        $this->mapWebPostRoutes();
        $this->mapWebOtherRoutes();
        $this->mapWebTeacherRoutes();
        $this->mapWebAdministorRoutes();

        $this->mapWebAuthRoutes();
        $this->mapWebFileRoutes();

        //
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
    protected function mapApiRoutes(){
        Route::prefix('api')->middleware('api')->namespace($this->namespace)->group(base_path('routes/api.php'));
    }

    protected function mapWebTaskRoutes(){
        Route::prefix('task')->middleware('web')->namespace($this->namespace)->group(base_path('routes/prefix/task.php'));
    }

    protected function mapWebPostRoutes(){
        Route::prefix('post')->middleware('web')->namespace($this->namespace)->group(base_path('routes/prefix/post.php'));
    }

    protected function mapWebOtherRoutes(){
        Route::prefix('other')->middleware('web')->namespace($this->namespace)->group(base_path('routes/prefix/other.php'));
    }

    protected function mapWebTeacherRoutes(){
        Route::prefix('teacher')->middleware('web')->namespace($this->namespace)->group(base_path('routes/prefix/teacher.php'));
    }

    protected function mapWebAdministorRoutes(){
        Route::prefix('administor')->middleware('web')->namespace($this->namespace)->group(base_path('routes/prefix/administor.php'));
    }

    protected function mapWebAuthRoutes(){
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/auth.php'));
    }

    protected function mapWebFileRoutes(){
        Route::prefix('files')->middleware('web')->namespace($this->namespace)->group(base_path('routes/file.php'));
    }
}
