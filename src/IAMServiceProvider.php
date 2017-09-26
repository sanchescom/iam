<?php
namespace thiagovictorino\IAM;

use Illuminate\Support\ServiceProvider;

use thiagovictorino\IAM\Services\IAMService;

class IAMServiceProvider extends ServiceProvider  {

    protected $defer = true;

    public function boot() {


        //$this->loadRoutesFrom(__DIR__ . '/../routes/iam.php');

        $this->publishes([__DIR__.'/../config/iam.php' => config_path('iam.php')], 'thiagovictorino-iam');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }
    public function register() {

        include __DIR__ . '/../routes/iam.php';
        $this->app->make(IAMService::class);
    }
    public function provides() {
        return ['thiagovictorino-iam'];
    }
}