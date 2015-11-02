<?php

namespace Code4\Notifications;

use Code4\Notifications\Storage\SessionStore;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider {

    public function register() {
        $config = realpath(__DIR__.'/../config/notifications.php');
        $this->mergeConfigFrom($config, 'notifications');
        $this->registerAliases();

        $this->app->singleton('notifications', function($app) {
            $config = $app['config']->get('notifications');
            $session = $app['session.store'];
            $notifications = new Notifications($config);

            $notifications->addStore('session', new SessionStore($session));

            return $notifications;
        });
    }

    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/notifications.php' => base_path('config/notifications.php')], 'config');
        $this->loadViewsFrom(__DIR__ . '/../views', 'notifications');
    }


    private function registerAliases() {
        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Notifications', Facades\Notifications::class);
    }


    public function terminate() {
    }
}