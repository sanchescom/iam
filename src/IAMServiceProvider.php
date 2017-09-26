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

        $this->app->bind(IAMService::class, function($app) {
            //$config = $app->make('config');
            //$uri = $config->get('mongo.uri');
            //$uriOptions = $config->get('mongo.uriOptions');
            //$driverOptions = $config->get('mongo.driverOptions');
            return new IAMService();
        });
    }
    public function provides() {
        return ['thiagovictorino-iam'];
    }
}