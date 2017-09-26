<?php
namespace thiagovictorino\IAM;

use Illuminate\Support\ServiceProvider;
use thiagovictorino\IAM\Services\IAMService;

class IAMServiceProvider extends ServiceProvider {

    protected $defer = true;

    public function boot() {

        $this->publishes([__DIR__.'/../config/iam.php' => config_path('iam.php')], 'iam');

        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

    }
    public function register() {

        $this->app->singleton(IAMService::class, function($app) {

            //$config = $app->make('config');
            //$uri = $config->get('mongo.uri');
            //$uriOptions = $config->get('mongo.uriOptions');
            //$driverOptions = $config->get('mongo.driverOptions');
            return new IAMService();
        });
    }
    public function provides() {
        return ['iam'];
    }
}