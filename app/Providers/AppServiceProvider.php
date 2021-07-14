<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::extend(function($value)
        {
            die('ok');
            return preg_replace('/@faker([\'\"]\s*?[\'\"])/', '<?php \Facade\Fake\Generator::$1; ?>', $value);
        });

        Blade::directive('faker', function ($expression) {
            return "<?php echo (\Facade\Faker\Generator::$expression()); ?>";
        });
    }
}
