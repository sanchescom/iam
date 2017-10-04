<?php
namespace thiagovictorino\IAM;

use Illuminate\Support\ServiceProvider;

use thiagovictorino\IAM\Services\IAMService;

class IAMServiceProvider extends ServiceProvider  {

    public function boot() {


        $this->loadRoutesFrom(__DIR__ . '/../routes/iam.php');

        $this->publishes([__DIR__.'/../config/iam.php' => config_path('iam.php')], 'thiagovictorino-iam');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }
    public function register() {

        $this->app->bind(IAMService::class, function() {
            return resolve(IAMService::class);
        });
    }
    public function provides() {
        return ['thiagovictorino-iam'];
    }
}