<template>
    <div id="svg-diagram-show-area" class="scrollXY" ref="field">
        <svg
            id="view-box"
            :viewBox="viewBoxDiagram"
            xmlns="http://www.w3.org/2000/svg"
        >
            <defs>
                <pattern
                    id="smallGrid"
                    width="10"
                    height="10"
                    patternUnits="userSpaceOnUse"
                >
                    <path
                        d="M 10 0 L 0 0 0 10"
                        fill="none"
                        stroke="gray"
                        stroke-width="0.5"
                    />
                </pattern>
                <pattern
                    id="grid"
                    width="100"
                    height="100"
                    patternUnits="userSpaceOnUse"
                >
                    <rect width="100" height="100" fill="url(#smallGrid)" />
                    <path
                        d="M 100 0 L 0 0 0 100"
                        fill="none"
                        stroke="gray"
                        stroke-width="1"
                    />
                </pattern>
            </defs>
            <g :transform="scaleStr" ref="box">
                <Node
                    :node="item"
                    v-for="item in nodes"
                    :key="item.id"
                    :scale="scale"
                />
                <Link
                    :link="item"
                    v-for="item in links"
                    :key="item.id"
                    :source="findNode(item.source)"
                    :destination="findNode(item.destination)"
                />
            </g>
        </svg>
    </div>
</template>
<script>
    import Node from "./lib/Node";
    import Link from "./lib/Link";
    export default {
        name: "Diagram",
        props: {
            scale: {
                type: String,
                default: "1"
            },
            background: String,
            nodes: Array,
            links: Array,
            fluid: {
                type: Boolean,
                default: false
            }
        },
        components: {
            Node,
            Link
        },
        computed: {
            viewBoxDiagram() {
                return `0 0 ${this.width} ${this.height}`
            },
            scaleStr() {
                return (
                    "scale(" +
                    (this.fluid ? 1.0 : this.scale || 1.0) +
                    ")" +
                    "translate(" +
                    0 +
                    "," +
                    0 +
                    ")"
                );
            }
        },
        data() {
            return {
                name: "",
                url: "",
                color: "",
                width: 0,
                height: 0
            };
        },
        methods: {
            generateID() {
                return (
                    new Date().getTime().toString(16) +
                    Math.floor(Math.random() * 1000000).toString(16)
                );
            },
            findNode(id) {
                return this.nodes.find(x => x.id === id);
            },
            rect() {
                return {
                    rWidth: this.fluid ? this.width : 1,
                    rHeight: this.fluid ? this.height : 1
                };
            }
        },
        mounted() {
            let box = this.$refs.box.getBBox();
            this.width = box.width + (box.width * .1);
            this.height = box.height + (box.height * .1);
        }
    };
</script>
<style>
    .button {
        cursor: pointer;
    }
    .grab {
        cursor: grab;
    }
</style>
