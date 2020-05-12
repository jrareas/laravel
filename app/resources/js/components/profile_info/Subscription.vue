<style scoped>
    .action-link {
        cursor: pointer;
    }
    .action-link:hover {
        background-color: rgba(131, 124, 149, 0.34);

        /* HOVER ON */
        -webkit-transition: border-radius 2s;
    }
    .loading {
        background-image: url("../../../assets/Spinner-1s-28px.svg");
        width:26px;
        height:26px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .active{
        color: green;
    }
    .oddrow{
        background-color: rgba(147, 161, 161, 0.06);
    }
    .modal-dialog {
        max-width: 100%;
    }
    .bold {
        font-weight: bold;
    }

    .fa-times {
        color:red;
    }
    .cancelled {
        text-decoration: line-through;
    }
    .tab-content {
        min-height: 120px;
    }
    pre {
        border: 1px solid grey
    }


</style>

<template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>
                            Subscriptions
                        </span>
                    <a class="action-link" tabindex="-1" @click="subcribe()">
                        Subscribe
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p class="mb-0" v-if="subscriptions.length === 0 && isLoading != true">
                    You have not subscribed to any API yet.
                </p>
                <div class="loading address" v-if="isLoading"></div>
                <div class="card card-default" v-for="subscription in subscriptions" v-if="subscriptions.length > 0">
                    <div class="card-body">
                        <b-container class="bv-row" fluid v-bind:class="{ cancelled : subscription.date_cancelation }">
                            <b-tabs pills card>
                                    <b-tab title="Details" active>
                                        <b-row class="">
                                            <b-col>
                                                <span class="bold">Name Api: </span>&nbsp; {{subscription.api.name}} <br>
                                                <strong>Uri:</strong> &nbsp;{{subscription.api.uri}} <br>
                                                <strong>Description:</strong> &nbsp;{{subscription.api.description}} <br>
                                                <strong>Plan:</strong> &nbsp;{{subscription.plan.name}} <br>
                                                <strong>Date Subscribed&nbsp;/&nbsp;Date Canceled:</strong> &nbsp;
                                                {{moment(subscription.date_subscribed).format('MMMM Do YYYY')}}&nbsp;/&nbsp;{{subscription.date_cancelation ? moment(subscription.date_cancelation).format('MMMM Do YYYY') : 'Current'}} <br>
                                            </b-col>
                                            <b-col class="text-right" v-if="subscription.date_cancelation == null">
                                                <a class="action-link fa fa-times" tabindex="-1" @click="handleCancel(subscription)">
                                                </a>&nbsp;
                                            </b-col>
                                        </b-row>
                                    </b-tab>
                                    <b-tab title="Example">
                                        <b-row class="">
                                            <b-col class="text-left">
                                                <label>Authentication (Before you are able to make a request you need to request an access_token)</label>
                                                <pre>
                                                  <code v-for="client in clients">
    curl --location --request POST 'https://theapitoolbox.com/oauth/token' \
        --header 'Content-Type: application/json' \
        --data-raw '{
            "grant_type" : "client_credentials",
            "client_id" : "{{ client.id }}",
            "client_secret" : "{{ client.secret }}"
        }'
                                                  </code>
                                                </pre>
                                                <label>Request( Replace [token] by the access_token from authorization request )</label>
                                                <pre>
                                                  <code>
    curl --location --request GET 'https://theapitoolbox.com/{{subscription.api.uri}}{{subscription.api.query_string ? "?" + subscription.api.query_string : ""}}'  \
        --header 'Accept: application/json' \
        --header 'Content-Type: application/json'
        --header 'Authorization: Bearer '[token]'
                                                  </code>
                                                </pre>
                                            </b-col>
                                        </b-row>
                                    </b-tab>
                            </b-tabs>
                        </b-container>
                    </div>
                </div>
            </div>
        </div>
        <subscribe-form :client_id="client_id" @subscribed="onSubscribed"></subscribe-form>
    </div>
</template>
<script>

    import moment from 'moment'
    import Subscribe from '../subscription/SubscribeForm';

    Vue.prototype.moment = moment

    export default {
        components: {
            'subscribe-form': Subscribe
        },
        props: ['authUser', 'clients'],
        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },
        data() {
            return {
                isLoading : true,
                apis:[],
                subscriptions:[],
                client_id: ''
            }
        },
        methods: {
            handleCancel(subscription){
                let self = this;
                this.$dialog
                    .confirm('Are you sure you want to cancel subscription?')
                    .then(function(dialog) {
                        self.cancel(subscription)
                    });
            },
            show() {
                this.getApis();
                $('#modal-add-subscription').modal('show');
            },
            cancel(subscription) {
                this.isLoading = true;
                axios.get('/subscriptions/cancel/' + subscription.id)
                    .then(response => {
                        this.getSubscriptions();
                        this.$toast.open('Subscription cancelled succesfully');
                    });
            },
            setClients(clients) {
                this.clients = clients;
                this.client_secret = clients[0].secret
                this.client_id = clients[0].id
            },
            /**
             * Get all of the OAuth clients for the user.
             */
            getApis() {
                axios.get('/apis')
                    .then(response => {
                        this.apis = response.data;
                        this.isLoading = false;
                    });
            },
            prepareComponent() {

                this.getSubscriptions();
            },
            getSubscriptions() {
                axios.get('/subscriptions/' + this.authUser.id)
                    .then(response => {
                        this.subscriptions = response.data;
                        this.isLoading = false;
                    });
            },
            subcribe() {
                this.client_id = this.clients[0].id
                Subscribe.showModal();
            },
            onSubscribed() {
                this.getSubscriptions();
            }
        }
    }
</script>