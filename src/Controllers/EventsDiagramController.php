<?php


namespace Mnikoei\EventsDiagram\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class EventsDiagramController extends Controller
{
    protected $events;

    public function show()
    {
        $reflectionClass = new \ReflectionClass(app('events'));
        $reflectionProperty = $reflectionClass->getProperty('listeners');
        $reflectionProperty->setAccessible(true);
        $events = $reflectionProperty->getValue(app('events'));

        $this->events = $events;
        $this->listenersCount();
        $flatten = [];
        $cnt= 1;
        foreach ($events as $event => $listeners){
            $arr[$event] = [];
            foreach ($listeners as $listener){
                $flatten[$event][] = (new \ReflectionFunction($listener))->getStaticVariables()['listener'];
            }
            $cnt++;
            if ($cnt>30){
//                break;
            }
        }

        $diagramData = $this->createDiagramData($flatten);

        return view('EventsDiagram::diagram', compact('diagramData'));
    }

    public function createDiagramData($events)
    {
        $diagramData = [
            'width' => 800,
            'height' => 600,
            'background' => "#eee",
            'nodes' => [],
            'links' => []
        ];

        foreach ($events as $event => $listeners){
            $eventNode =  $this->createEventNode($event);
            $diagramData['nodes'][] = $eventNode;

            foreach ($listeners as $listener){
                $listenerNode = $this->createListenerNode($listener);
                $diagramData['nodes'][] = $listenerNode;

                $link = $this->createLinkNode($listenerNode, $eventNode);
                $diagramData['links'][] = $link;
            }
        }
        return $diagramData;
    }

    public function createEventNode($event)
    {
        $shit = $this->listenersCount() * 80;
        $gap = $shit / count($this->events);

        static $y = 0 ;
        return [
            'id' => Str::random(),
            'content' => [
                'text' => $event,
                'color' => '#fab1a0'
            ],
            'width' => strlen($event) * 12,
            'height' => 45,
            'point' => ['x' => 50, 'y' => $y += $gap],
            'shape' => 'rectangle',
            'stroke' => 'transparent',
            'strokeWeight' => 2
        ];
    }

    public function createListenerNode($listener)
    {
        static $y = 0;
        return [
            'id' => Str::random(),
            'content' => [
                'text' => is_object($listener) ? 'shit' : $listener,
                'color' => '#00AFF0'
            ],
            'width' => is_object($listener) ? 20 : strlen($listener) * 12,
            'height' => 45,
            'point' => ['x' => 1200, 'y' => $y += 80],
            'shape' => 'rectangle',
            'stroke' => 'transparent',
            'strokeWeight' => 2
        ];
    }

    public function createLinkNode($sourceNode, $destinationNode)
    {
        return [
            'id' => Str::random(),
            'source' => $sourceNode['id'],
            'destination' => $destinationNode['id'],
            'color' => '#74b9ff',
            'pattern' => 'solid',
            'arrow' => 'dest'
        ];
    }

    public function listenersCount()
    {
        $listeners = array_values($this->events);
        return array_reduce($listeners, function ($sum, $items){
            return $sum + count($items);
        }, 0);
    }
}
