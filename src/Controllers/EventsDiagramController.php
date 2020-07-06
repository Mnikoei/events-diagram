<?php


namespace Mnikoei\EventsDiagram\Controllers;


use App\Http\Controllers\Controller;

class EventsDiagramController extends Controller
{

    public function show()
    {

        $reflectionClass = new \ReflectionClass(app('events'));
        $reflectionProperty = $reflectionClass->getProperty('listeners');
        $reflectionProperty->setAccessible(true);
        $eventListeners = $reflectionProperty->getValue(app('events'));

        $flatten = [];
        foreach ($eventListeners as $event => $listeners){
            $arr[$event] = [];
            foreach ($listeners as $listener){
                $flatten[$event][] = (new \ReflectionFunction($listener))->getStaticVariables()['listener'];
            }
        }

        $diagramData = $this->createDiagramJson($flatten);

//        dd($diagramData);

        return view('EventsDiagram::diagram', compact('diagramData'));
    }

    public function createDiagramJson($events)
    {
        $map = [];
        foreach ($events as $event => $listeners){

            $children = [];
            foreach ($listeners as $listener){
                $children['children'][] = ['text' => ['name' => $listener]];
            }
            $map[] = array_merge(['text' => ['name' => $event]], $children);
        }
        return json_encode($map, JSON_PRETTY_PRINT);
    }

}
