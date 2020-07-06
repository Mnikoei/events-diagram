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
            if ($cnt>1){break;
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
            $eventNode =  $this->createNode($event);
            $diagramData['nodes'][] = $eventNode;

            foreach ($listeners as $listener){
                $listenerNode = $this->createNode($listener);
                $diagramData['nodes'][] = $listenerNode;

                $link = $this->createLinkNode($listenerNode, $eventNode);
                $diagramData['links'][] = $link;
            }
        }
        return $diagramData;
    }

    public function createNode($event)
    {
        return [
            'id' => Str::random(),
            'content' => [
                'text' => $event,
                'color' => '#fab1a0'
            ],
            'width' => 150,
            'height' => 160,
            'point' => ['x' => rand(0, 1000), 'y' => rand(0, 1000)],
            'shape' => 'rectangle',
            'stroke' => 'black',
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
                'x' => random_int(0, 1000),
                'y' => 83.74688965089885
             ],
            'color' => '#74b9ff',
            'pattern' => 'solid'
        ];
    }
}
