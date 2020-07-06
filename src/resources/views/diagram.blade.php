<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">




    <title>Document</title>
</head>
<body >

<div id="app">

    <Diagram
        :width="2000"
        :height="1000"
        scale="1"
        background="#fafafa"
        :nodes="nodes"
        :links="links"
        :editable="editable"
        :labels="{
        edit: 'Edit',
        remove: 'Remove',
        link: 'Link',
        select: 'Select'
        }"
        @editNode="editNode"
        @editLink="editLink"
        @nodeChanged="nodeChanged"
        @linkChanged="linkChanged"
    >
    ></Diagram>

</div>

</body>
<script>
    var data = {!! stripcslashes(json_encode($diagramData)) !!};
    console.log(data)
    // var data = {
    //     "width": 800,
    //     "height": 600,
    //     "background": "#eee",
    //     "nodes": [{
    //         "id": "17214bb721d65c81",
    //         "content": {"text": "Wake up", "color": "white"},
    //         "width": 150,
    //         "height": 60,
    //         "stroke": "black",
    //         "strokeWeight": "2",
    //         "shape": "rectangle",
    //         "point": {"x": 100, "y": 31.056557875214764}
    //     }, {
    //         "id": "17214bbccb87e56a",
    //         "content": {"text": "Brush my teeth", "color": "white"},
    //         "width": 180,
    //         "height": 60,
    //         "point": {"x": 514, "y": 143.05655787521476},
    //         "shape": "rectangle",
    //         "stroke": "black",
    //         "strokeWeight": "2"
    //     }, {
    //         "id": "17214bd99f6dfb81",
    //         "content": {"text": "Have breakfast", "color": "white"},
    //         "width": 180,
    //         "height": 60,
    //         "point": {"x": 524, "y": 304.05655787521476},
    //         "shape": "rectangle",
    //         "stroke": "red",
    //         "strokeWeight": "2"
    //     }, {
    //         "id": "17214beb6802f9d5",
    //         "content": {"text": "Have lunch", "color": "white"},
    //         "width": 150,
    //         "height": 60,
    //         "stroke": "red",
    //         "strokeWeight": "2",
    //         "shape": "rectangle",
    //         "point": {"x": 400, "y": 432.24028293572763}
    //     }, {
    //         "id": "17214bf28b22eb4c",
    //         "content": {"text": "Siesta", "color": "white"},
    //         "width": 150,
    //         "height": 60,
    //         "stroke": "black",
    //         "strokeWeight": "2",
    //         "shape": "rectangle",
    //         "point": {"x": 175, "y": 432.85606145781674}
    //     }, {
    //         "id": "17214bf4e485a3d7",
    //         "content": {"text": "Have dinner", "color": "white"},
    //         "width": 150,
    //         "height": 60,
    //         "point": {"x": 37, "y": 303.24028293572763},
    //         "shape": "rectangle",
    //         "stroke": "red",
    //         "strokeWeight": "2"
    //     }, {
    //         "id": "17214bfb13e18321",
    //         "content": {"text": "Go to bed", "color": "white"},
    //         "width": 150,
    //         "height": 60,
    //         "point": {"x": 39, "y": 152.85606145781674},
    //         "shape": "rectangle",
    //         "stroke": "black",
    //         "strokeWeight": "2"
    //     }],
    //     "links": [{
    //         "id": "1680e25b9919ba70",
    //         "source": "17214bfb13e18321",
    //         "destination": "17214bf28b22eb4c",
    //         "point": {
    //             "x": 500.5,
    //             "y": 109.49883251758314
    //         },
    //         "color": "#74b9ff",
    //         "arrow": "both"
    //     },{
    //         "id": "1680e25b9919ba71",
    //         "source": "17214bfb13e18321",
    //         "destination": "17214beb6802f9d5",
    //         "point": {
    //             "x": 500.5,
    //             "y": 109.49883251758314
    //         },
    //         "color": "#74b9ff",
    //         "arrow": "both"
    //     }
    //     ],
    //     "showGrid": false,
    //     editable: ''
    // };
</script>
<script src="{{asset('vendor/events-diagram/app.js')}}" ></script>

</html>
