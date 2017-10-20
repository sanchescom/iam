<?php

namespace thiagovictorino\IAM\Test;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use thiagovictorino\IAM\IAMServiceProvider;

/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 9/26/17
 * Time: 20:12
 */
class AbstractTestCase extends \Illuminate\Foundation\Testing\TestCase {



    //use RefreshDatabase;
    /**
     * Setup DB before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->app['config']->set('database.migrations','migrations');
        $this->app['config']->set('database.default','sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        $this->app['config']->set('iam.jwt_alg', 'HS256');
        $this->app['config']->set('iam.jwt_secret', 'hash');
        $this->app['config']->set('iam.jwt_expiration_time', '5');

        $this->migrate();
    }


    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->register(IAMServiceProvider::class);

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * run package database migrations
     *
     * @return void
     */
    public function migrate()
    {
        /**
         * @var $migrator Migrator
         */
        $migrator =  $this->app->make('migrator');

        /**
         * @var $migratonRepository DatabaseMigrationRepository
         */
        $migratonRepository =  $this->app->make('migration.repository');

        $migratonRepository->createRepository();

        $migrator->run([__DIR__ . "/../database/migrations"]);

    }
}