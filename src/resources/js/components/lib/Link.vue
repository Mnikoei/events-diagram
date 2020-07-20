<template>
    <g>
        <path
            :d="
        `M${calcSource().x} ${calcSource().y}

        ${calcDestination().x} ${calcDestination().y}`
      "
            :stroke="link.color || '#ffeaa7'"
            stroke-width="3"
            fill="none"
            :stroke-dasharray="definePattern(link.pattern)"
            :marker-start="
        link.arrow === 'src' || link.arrow === 'both' ? `url(#${link.id})` : ''
      "
            :marker-end="
        link.arrow === 'dest' || link.arrow === 'both' ? `url(#${link.id})` : ''
      "
        />
        <marker
            :id="link.id"
            markerUnits="userSpaceOnUse"
            orient="auto-start-reverse"
            markerWidth="15"
            markerHeight="15"
            viewBox="0 0 10 10"
            refX="5"
            refY="5"
        >
            <polygon points="0,1.5 0,8.5 10,5 " :fill="link.color || '#ffeaa7'" />
        </marker>
    </g>
</template>
<script>
    export default {
        props: {
            source: {
                id: Number,
                x: Number,
                y: Number
            },
            destination: {
                id: Number,
                x: Number,
                y: Number
            },
            link: {
                id: String,
                color: {
                    type: String,
                    default: "#ffeaa7"
                },
                pattern: {
                    type: String,
                    default: "solid"
                },
                arrow: {
                    type: String,
                    default: "none"
                },
            }
        },
        computed: {},
        data() {
            return {
                startPosition: null,
                cursorOffset: {
                    x: 0,
                    y: 0
                },
                id: this.link.id
            };
        },
        methods: {
            definePattern(p) {
                if (p === "solid") {
                    return 0;
                } else if (p === "dash") {
                    return 10;
                } else if (p === "dot") {
                    return 3;
                } else {
                    return 0;
                }
            },
            calcSource() {
                return {
                    x: this.source.point.x,
                    y: this.source.point.y + this.source.height / 2
                };
            },
            calcDestination() {
                return {
                    x: this.destination.point.x + this.destination.width,
                    y: this.destination.point.y + this.destination.height / 2
                };
            }
        }
    };
</script>
<style scoped></style>
