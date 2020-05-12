<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>



<template>
    <div>
        <loading :active.sync="isLoading"
                 :can-cancel="true"
                 :on-cancel="onCancel"
                 :is-full-page="fullPage"></loading>
        <div class="card-body">
            <client-info v-bind:clients="clients"></client-info>
            <personal-info v-bind:authUser="authUser"></personal-info>
            <address-info v-bind:authUser="authUser"></address-info>
            <api-subscription v-bind:authUser="authUser" v-bind:clients="clients" v-if="clients.length > 0"></api-subscription>
        </div>
    </div>
</template>

<script>
    import ClientInfo from './ClientInfo'
    // Import component
    import Loading from 'vue-loading-overlay'
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css'
    export default {
        components: {
            ClientInfo
        },
        props: ['authUser'],
        components: {
            Loading
        },
        data() {
            return {
                clients: [],
                fullPage: false,
                isLoading: true,
            }
        },
        mounted() {
            this.prepareComponent();
        },
        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getClients();

                $('#modal-create-client').on('shown.bs.modal', () => {
                    $('#create-client-name').focus();
                });

                $('#modal-edit-client').on('shown.bs.modal', () => {
                    $('#edit-client-name').focus();
                });
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            getClients() {
                axios.get('/oauth/clients')
                    .then(response => {
                        this.clients = response.data;
                        this.isLoading = false;
                    });
            }
        }
    }
</script>