<template>
  <g>
    <ellipse
      v-if="node.shape === 'ellipse'"
      class="grab"
      :cx="x + node.width / 2"
      :cy="y + node.height / 2"
      :width="node.width"
      :height="node.height"
      :rx="node.width / 2"
      :ry="node.height / 2"
      :fill="content.color || '#ecf0f1'"
      :stroke-width="node.strokeWeight"
      :stroke="node.stroke"
    />
    <rect
      v-else
      class="grab"
      :x="x"
      :y="y"
      :width="node.width"
      :height="node.height"
      rx="5"
      ry="3"
      :fill="content.color || '#ecf0f1'"
      :stroke-width="node.strokeWeight"
      :stroke="node.stroke"
    />
    <a target="_blank" :href="content.url">
      <text
        :x="x + node.width / 2"
        :y="y + node.height / 2"
        fill="#34495e"
        font-family="Meiryo UI, sans-serif"
        font-size="20"
        text-anchor="middle"
      >
        {{ content.text }}
      </text>
    </a>
  </g>
</template>
<script>

export default {
  props: {
    node: {
      width: Number,
      height: Number,
      id: String,
      point: {
        type: Object,
        default: {
          x: 0,
          y: 0
        }
      },
      content: {
        text: String,
        url: String,
        color: String
      },
      shape: {
        type: String,
        default: "rectangle"
      },
      stroke: String,
      strokeWeight: Number
    }
  },
  watch: {
    node() {
      this.x = this.node.point.x;
      this.y = this.node.point.y;
    }
  },
  data() {
    return {
      startPosition: null,
      cursorOffset: {
        x: 0,
        y: 0
      },
      id: this.node.id,
      x: this.node.point.x,
      y: this.node.point.y,
      content: this.node.content
    };
  }
};
</script>
<style lang="scss" scoped>
.shadow {
  filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
  -webkit-filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
  -moz-filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
}
.button {
  cursor: pointer;
}
</style>
