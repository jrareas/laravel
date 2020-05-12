<template>
    <div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                apis:[],
            }
        },
        ready(){

        },
        methods: {
            getApis() {
                axios.get('/apispublic')
                    .then(response => {
                        this.apis = response.data;
                        this.isLoading = false;
                    });
            }
        }

    }
</script>