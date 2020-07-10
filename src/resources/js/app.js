require('./bootstrap');

window.Vue = require('vue');

import Diagram from './components/Diagram';
import "../css/diagram.css";

app = new Vue({
    el: '#app',

    data: data,

    methods: {
        editNode(node /* selected node */) {
            /* event handler */
        },
        editLink(link /* selected link */) {
            /* event handler */
        },
        nodeChanged(obj /* array of nodes */) {
            /* event handler */
            const nodes = obj.nodes
        },
        linkChanged(obj /* array of links */) {
            /* event handler */
            const links = obj.links
        }
    },

    components: {
        Diagram
    }
});
