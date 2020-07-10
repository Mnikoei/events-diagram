<?php


namespace Mnikoei\EventsDiagram\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class EventsDiagramController extends Controller
{

    public function show()
    {
        $reflectionClass = new \ReflectionClass(app('events'));
        $reflectionProperty = $reflectionClass->getProperty('listeners');
        $reflectionProperty->setAccessible(true);
        $eventListeners = $reflectionProperty->getValue(app('events'));

        $flatten = [];
        $cnt= 1;
        foreach ($eventListeners as $event => $listeners){
            $arr[$event] = [];
            foreach ($listeners as $listener){
                $flatten[$event][] = (new \ReflectionFunction($listener))->getStaticVariables()['listener'];
            }
            $cnt++;
            if ($cnt>10){break;
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
            'links' => [],
            'editable' => false
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
        static $y = 0 ;
        return [
            'id' => Str::random(),
            'content' => [
                'text' => $event,
                'color' => '#fab1a0'
            ],
            'width' => strlen($event) * 12,
            'height' => 45,
            'point' => ['x' => 50, 'y' => $y += 100],
            'shape' => 'rectangle',
            'stroke' => 'transparent',
            'strokeWeight' => 2
        ];
    }

    public function createListenerNode($event)
    {
        static $y = 0;
        return [
            'id' => Str::random(),
            'content' => [
                'text' => $event,
                'color' => '#00AFF0'
            ],
            'width' => strlen($event) * 12,
            'height' => 45,
            'point' => ['x' => 800, 'y' => $y += 80],
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
            'point'=> [
                'x' => 0,
                'y' => 0
             ],
            'color' => '#74b9ff',
            'pattern' => 'solid',
            'arrow' => 'dest'
        ];
    }
}
