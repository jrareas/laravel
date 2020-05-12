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

</style>
<template>
    <div>
        <div class="loading api" v-if="isLoading"></div>
        <div>
            <b-container class="bv-row" fluid v-if="apis.length > 0">
                <b-row v-for="api in apis" :key="api.id" class="text-center">
                    <a @click="showDoc(api)" >
                        <b-col class="action-link" @click="showDoc(api)">{{ api.name }}</b-col>
                    </a>
                </b-row>
            </b-container>
        </div>
        <div class="modal fade" id="modal-api-doc" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Api Document ({{ selectedApi.name }})
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="loading" v-if="isLoadingDoc"></div>
                        <vue-markdown :source="content"></vue-markdown>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueMarkdown from 'vue-markdown'
    export default {
        props:['uri'],
        components: {
            VueMarkdown
        },
        data() {
            return {
                isLoading : true,
                isLoadingDoc: false,
                odd: false,
                apis: [],
                selectedApi:{},
                content:'<p>Loading...</p>'
            }
        },
        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },
        methods: {
            showDoc(selectedApi) {
                this.content = '';
                this.selectedApi = selectedApi
                this.isLoadingDoc = true;
                $('#modal-api-doc').modal('show');
                this.$http.get(selectedApi.docs_uri).then(response => {
                    this.content = response.data;
                    this.isLoadingDoc = false;
                });
            },
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getApis();
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
            oddRow() {
                this.odd = !this.odd
                return this.odd ? "oddrow" : ""
            }
        }
    }

</script>

