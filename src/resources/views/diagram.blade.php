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
        scale=".7"
        :fluid="true"
        background="#fafafa"
        :nodes="nodes"
        :links="links"
    >
    ></Diagram>

</div>

</body>
<script>
    var data = {!! str_replace('\\', '/', stripcslashes(json_encode($diagramData))) !!};
</script>
<script src="{{asset('vendor/events-diagram/app.js')}}" ></script>

</html>
