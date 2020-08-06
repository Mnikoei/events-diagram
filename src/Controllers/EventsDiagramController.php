<?php


namespace Mnikoei\EventsDiagram\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EventsDiagramController extends Controller
{

    public function show()
    {
        $reflectionClass = new \ReflectionClass(app('events'));
        $reflectionProperty = $reflectionClass->getProperty('listeners');
        $reflectionProperty->setAccessible(true);
        $events = $reflectionProperty->getValue(app('events'));

        $diagramData = $this->createDiagramData($events);

        return view('EventsDiagram::diagram', compact('diagramData'));
    }

    public function createDiagramData($events)
    {
        return array_map(function ($listeners){

            return array_map(function ($listenerObject){

                // Get listener name from it's closure
                return $this->getListenerName($listenerObject);

            }, $listeners);

        }, $events);
    }

    public function getListenerName($listener)
    {
        $name = (new \ReflectionFunction($listener))->getStaticVariables()['listener'];

        if (is_object($name)){
            $listenerClosure = (new \ReflectionFunction($name));

            $filename = $listenerClosure->getFileName();
            $startLine = $listenerClosure->getStartLine();
            $endLine = $listenerClosure->getEndLine();

            $name = "$filename line $startLine to $endLine <closure>";
        }

        return $name;
    }
}
