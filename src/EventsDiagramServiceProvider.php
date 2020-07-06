<?php
namespace Mnikoei\EventsDiagram;

use Illuminate\Support\ServiceProvider;

class EventsDiagramServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'EventsDiagram');
        $this->publishes([
            __DIR__.'/../assets' => public_path('vendor/events-diagram/'),
        ], 'public');

        $this->app['router']->get('events-diagram', 'Mnikoei\EventsDiagram\Controllers\EventsDiagramController@show');
    }

}
