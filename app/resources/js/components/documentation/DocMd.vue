<template>
    <div>
        {{ content }}
    </div>
</template>

<script>
    var VueMarkdown = require('vue-markdown');
    export default {
        props:['apiid'],
        components: {
            'vue-markdown': VueMarkdown
        },
        data() {
            return {
                content:""
            }
        },
        methods: {
            getDoc() {

            }

        },

    }

</script>
