<?php
namespace Mnikoei;

use Illuminate\Support\ServiceProvider;

class EventsDiagramServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app['router']->get('events-diagram', 'Mnikoei\EventsDiagram\EventsDiagramController@show');
    }

}
