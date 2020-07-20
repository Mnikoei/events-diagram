require('./bootstrap');

window.Vue = require('vue');

import Diagram from './components/Diagram';
import "../css/diagram.css";

app = new Vue({
    el: '#app',

    data: data,

    components: {
        Diagram
    }
});
