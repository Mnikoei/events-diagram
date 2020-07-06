<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <script src="{{asset('vendor/events-diagram/app.js')}}" defer></script>


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

</html>
