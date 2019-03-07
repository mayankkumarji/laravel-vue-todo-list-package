<?php 
namespace Mayank\TodoTask;

use Illuminate\Support\ServiceProvider;

class TodoTaskServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'todotask');

        $this->publishes([__DIR__.'/Views' => base_path('/resources/views/todo'),], 'views');
        $this->publishes([__DIR__.'/assets' => public_path('/todo')], 'public');
        $this->publishes([__DIR__.'/migrations/' => database_path('migrations')], 'migrations');
    }

    public function register()
    {
        $this->app->singleton(TodoTask::class, function () {
            return new TodoTask();
        });

        $this->app->alias(TodoTask::class, 'todotask');

    }

}