<style scoped>
    .action-link {
        cursor: pointer;
    }
    .loading {
        background-image: url("../../../assets/Spinner-1s-28px.svg");
        width:26px;
        height:26px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .plan_box{
        border: 1px solid lightgrey;
        border-radius:5px;
        text-align:center;
        min-height: 120px;
    }
    .plan_box .plan_name {
        clear: both;
        color:red;
        font-size:24px;
        font-weight: bold;
    }
    .plan_conditions {
        font-size:12px;
        clear: both;
    }
    .plan_prices.free {
        text-decoration: line-through;
    }
    .plan_prices_overlimit {
        font-size:8px;
    }
    .selected {
        background-color: #93a1a1;
    }
</style>
<template>
    <div class="modal fade" id="modal-subscription" tabindex="-1" role="dialog">
        <div class="loading address" v-if="isLoadingApis && isLoadingPlans "></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Subscribe
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <!-- Form Errors -->
                    <div class="alert alert-danger" v-if="formData.errors.length > 0">
                        <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                        <br>
                        <ul>
                            <li v-for="error in formData.errors">
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <!-- Create Address Form -->
                    <form role="form">
                        <!-- Apis -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Api</label>

                            <div class="col-md-9">
                                <div class="checkbox">
                                    <label>
                                        <select v-if="apis.length > 0" v-model="formData.api_id">
                                            <option id="-1"> Please Select ... </option>
                                            <option v-for="api in apis" v-bind:value="api.id" >{{ api.name }}</option>
                                        </select>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Plans</label>
                            <div class="container">
                                <div class="row">
                                    <div class="checkbox col-md-4" v-for="plan in plans">
                                        <div class="plan_box" v-on:click="select(plan)" v-bind:class="{selected : plan.id == formData.plan_id}">
                                            <div class="plan_name">{{ plan.name }}</div>
                                            <div class="plan_conditions" v-if="plan.condition.cicle == 'Unlimited'">Unlimited</div>
                                            <div class="plan_conditions" v-else>{{ plan.condition.condition_qty }}&nbsp;{{ plan.condition.condition }}/{{ plan.condition.cicle }}</div>
                                            <div class="plan_prices" v-bind:class="{ 'free': plan.condition.price == 0}">{{ plan.condition.price == 0 ? `Free` :  plan.condition.price }}</div>
                                            <div class="plan_prices_overlimit" >{{ plan.condition.condition_qty ? `Amount per request over the limit: ` + plan.condition.price_overlimit : ''  }}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary" @click="subscribe">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'client_id'
        ],
        data() {
            return {
                plans:[],
                apis: [],
                isLoadingApis: true,
                isLoadingPlans:true,
                formData : {
                    errors: [],
                    api_id:'',
                    plan_id: '',
                    client_id: ''
                }
            }
        },
        mounted() {
            this.prepareComponent();
        },
        showModal(api) {
            $('#modal-subscription').modal('show');
            this.isLoadingPlans = true;
            this.isLoadingApis = true;
            if(api) {
                this.formData.api_id = api.id;
            }
        },
        methods: {
            select(plan){
                this.formData.plan_id = plan.id;
            },
            getPlans() {
                axios.get('/plans')
                    .then(response => {
                        this.plans = response.data;
                        this.isLoadingPlans = false;
                    });
            },
            /**
             * Get all of the OAuth clients for the user.
             */
            getApis() {
                axios.get('/apis')
                    .then(response => {
                        this.apis = response.data;
                        this.isLoadingApis = false;
                    });
            },
            prepareComponent(){
                this.getApis()
                this.getPlans()
                $('#modal-subscription').on('shown.bs.modal', () => {
                });
            },
            subscribe() {
                this.formData.client_id = this.client_id;
                axios.post('/subscribe',this.formData)
                    .then(response => {
                        this.apis = response.data;
                        this.isLoadingApis = false;
                        $('#modal-subscription').modal('hide');
                        this.$emit('subscribed', 'true')
                    }).catch(error => {
                    if (typeof error.response.data === 'object') {
                        this.formData.errors = _.flatten(_.toArray(error.response.data.errors));
                    } else {
                        this.formData.errors = ['Something went wrong. Please try again.'];
                    }
                });
            },
            onShow(subscription) {

            }
        }
    }
</script>