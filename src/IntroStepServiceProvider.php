<?php
namespace Bisync\IntroStep;

use Bisync\IntroStep\Facade\IntroStep;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class IntroStepServiceProvider extends ServiceProvider {
    public function boot() {

        $this->loadViewsFrom(__DIR__ . '/Views', 'intro_step');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->mergeConfigFrom(__DIR__ . '/config/intro-step.php', 'intro-step');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'intro_step');

        $this->publishes([
            __DIR__ . '/public'                => public_path('vendor/bisync/intro-step'),
            __DIR__ . '/config/intro-step.php' => config_path('intro-step.php'),
            __DIR__ . '/database/migrations'   => database_path('migrations'),
            __DIR__ . '/app'                   => app_path(),
        ]);

        $this->publishes([
            __DIR__ . '/lang' => resource_path('lang/vendor/intro_step'),
        ]);

        Blade::directive('intro_step', function ($withScript = true) {
            if ($withScript === '') {
                $withScript = true;
            }
            return IntroStep::getBladeScript($withScript);
        });
    }

    public function register() {
        $this->app->bind('introStep', function () {
            return new \Bisync\IntroStep\Facade\IntroStep;
        });
    }
}
