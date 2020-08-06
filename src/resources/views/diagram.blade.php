<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <style>
        body, .stage {
            background: #042029;
        }
        .popup {
            background: white;
            position: absolute;
            padding: 1rem;
            border-radius: .5rem;
            opacity: 0;
            transition: opacity .7s;
        }
    </style>

    <script src="https://d3js.org/d3.v3.min.js"></script>

</head>
<body onmousemove="updatePointerPosition(event)">

    <div id="popup" class="popup">
        hello
    </div>

</body>
<script>

    var popup = document.getElementById('popup');

    var mouseX;
    var mouseY;

    var data = {!! str_replace('\\', '/', stripcslashes(json_encode($diagramData))) !!}


    const nets = [];
    Object.entries(data).forEach(entry => {
        const [event, listeners] = entry;
        const nodes = [];

        nodes.push({
            name : event
        });

        listeners.forEach(listener => {
            nodes.push({
                name : listener
            });
        });

        nets.push(nodes);
    });

    nets.forEach(function(nodes){
        create(nodes, createLinks(nodes));
    });

    // The first node is target node and the rest are source node
    function createLinks(nodes){
        const links = [];
        const targetNode = nodes[0];

        nodes.forEach(node => {
            links.push({ source : node, target : targetNode});
        });

        return links;
    }


    function create(nodes, links){

        var w = 600;
        var h = 400;

        var circleWidth = 7;

        var palette = {
            "lightgray": "#819090",
            "gray": "#708284",
            "mediumgray": "#536870",
            "darkgray": "#475B62",

            "darkblue": "#0A2933",
            "darkerblue": "#042029",

            "paleryellow": "#FCF4DC",
            "paleyellow": "#EAE3CB",
            "yellow": "#A57706",
            "orange": "#BD3613",
            "red": "#D11C24",
            "pink": "#C61C6F",
            "purple": "#595AB7",
            "blue": "#2176C7",
            "green": "#259286",
            "yellowgreen": "#738A05"
        };



        var vis = d3.select("body")
            .append("svg:svg")
            .attr("class", "stage")
            .attr("width", w)
            .attr("height", h);

        var force = d3.layout.force()
            .nodes(nodes)
            .links([])
            .gravity(0.1)
            .charge(-1000)
            .size([w, h]);

        console.log(force);
        var link = vis.selectAll(".link")
            .data(links)
            .enter().append("line")
            .attr("class", "link")
            .attr("stroke", "#CCC")
            .attr("fill", "none");

        var node = vis.selectAll("circle.node")
            .data(nodes)
            .enter().append("g")
            .attr("class", "node")

            //MOUSEOVER
            .on("mouseover", function(d,i) {
                if (i > 0) {
                    //CIRCLE
                    d3.select(this).selectAll("circle")
                        .transition()
                        .duration(250)
                        .style("cursor", "none")
                        .attr("r", circleWidth+3)
                        .attr("fill",palette.orange);

                    //TEXT
                    d3.select(this).select("text")
                        .transition()
                        .style("cursor", "none")
                        .duration(250)
                        .style("cursor", "none")
                        .attr("font-size","1.5em")
                        .attr("x", 15 )
                        .attr("y", 5 )
                } else {
                    //CIRCLE
                    d3.select(this).selectAll("circle")
                        .style("cursor", "none");

                    //TEXT
                    d3.select(this).select("text")
                        .style("cursor", "none")
                }
            })

            //MOUSEOUT
            .on("mouseout", function(d,i) {
                if (i > 0) {
                    //CIRCLE
                    d3.select(this).selectAll("circle")
                        .transition()
                        .duration(250)
                        .attr("r", circleWidth)
                        .attr("fill",palette.pink);

                    //TEXT
                    d3.select(this).select("text")
                        .transition()
                        .duration(250)
                        .attr("font-size","1em")
                        .attr("x", 8 )
                        .attr("y", 4 )
                }
            })

            .call(force.drag);


        //CIRCLE
        node.append("svg:circle")
            .attr("cx", function(d) { return d.x; })
            .attr("cy", function(d) { return d.y; })
            .attr("r", circleWidth)
            .attr("fill", function(d, i) { if (i>0) { return  palette.pink; } else { return palette.paleryellow } })
            .on('mouseover', function (node) {
                popup.innerText = node.name;
                popup.style.left = mouseX + "px";
                popup.style.top = mouseY + "px";
                popup.style.opacity = "1";
            }).on('mouseout', function () {
                setTimeout(() => { popup.style.opacity = "0" }, 700)
            });


        //TEXT
        node.append("text")
            .text(function(node, i) {
                return node.name.split('/').slice(-1).pop();
            })
            .attr("x",            function(d, i) { if (i>0) { return circleWidth + 5; }   else { return -10 } })
            .attr("y",            function(d, i) { if (i>0) { return circleWidth + 0 }    else { return 8 } })
            .attr("font-family",  "Bree Serif")
            .attr("fill",         function(d, i) { if (i>0) { return  palette.paleryellow; }        else { return palette.yellowgreen } })
            .attr("font-size",    function(d, i) { if (i>0) { return  "1em"; }            else { return "1.8em" } })
            .attr("text-anchor",  function(d, i) { if (i>0) { return  "beginning"; }      else { return "end" } })



        force.on("tick", function(e) {
            node.attr("transform", function(d, i) {
                return "translate(" + d.x + "," + d.y + ")";
            });

            link.attr("x1", function(d)   { return d.source.x; })
                .attr("y1", function(d)   { return d.source.y; })
                .attr("x2", function(d)   { return d.target.x; })
                .attr("y2", function(d)   { return d.target.y; })
        });

        force.start();
    }

    function updatePointerPosition(event) {
        mouseX = event.layerX;
        mouseY = event.layerY;
    }
</script>

</html>
