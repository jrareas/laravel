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
    .active{
        color: green;
    }
    tbody tr:nth-child(odd) td{
        background-color: #c5cddd;
    }
</style>
<template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        Apis
                    </span>

                    <a class="action-link" tabindex="-1" @click="showCreateApiForm">
                        Create New Api
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p class="mb-0" v-if="apis.length === 0 && isLoading != true">
                    You have not created any Api.
                </p>
                <div class="loading api" v-if="isLoading"></div>
                <table class="table table-borderless mb-0" v-if="apis.length > 0">
                    <thead>
                    <tr>
                        <th>Uri</th>
                        <th>Query</th>
                        <th>Method</th>
                        <th>Headers</th>
                        <th>Docs</th>
                        <th>Active</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="api in apis">
                        <td style="vertical-align: middle;">
                            {{ api.uri }}

                        </td>
                        <td style="vertical-align: middle;">
                            {{ api.query_string }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ api.method }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ api.headers }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ api.docs_uri }}
                        </td>
                        <td style="vertical-align: middle;">
                            <span v-if="api.enabled" class="active fa fa-check"></span>
                        </td>

                        <!-- Edit Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link fa fa-edit" tabindex="-1" @click="edit(api)">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create api Modal -->
        <div class="modal fade" id="modal-create-api" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ formLabel }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create api Form -->
                        <form role="form">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input  type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.name">
                                    <span class="form-text text-muted">
                                        Give it a meaningful name
                                    </span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Description</label>

                                <div class="col-md-9">
                                    <input  type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.description">
                                    <span class="form-text text-muted">
                                        Describe your api in few words
                                    </span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Description</label>

                                <div class="col-md-9">
                                    <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input" @keyup.enter="store" />
                                    <div class="loading api" v-if="isUploadingImage"></div>
                                </div>
                            </div>

                            <div class="form-group row" v-if="createForm.imageUri != ''">
                                <div class="col-md-9">
                                    <img v-bind:src="imageUri" />

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">URI</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.uri">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Query String</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="query_string"
                                           @keyup.enter="store" v-model="createForm.query_string">

                                    <span class="form-text text-muted">
                                        Use replacement as {}(i.e key={value}
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Method</label>

                                <div class="col-md-9">
                                    <div class="dropdown">
                                        <label>
                                            <select v-if="methods.length > 0" v-model="createForm.method"  class="form-control">
                                                <option > Please Select ... </option>
                                                <option v-for="method in methods"  >{{ method }}</option>
                                            </select>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Headers</label>

                                <div class="col-md-9">
                                    <label>
                                        <textarea v-model="createForm.headers"  class="form-control" />
                                    </label>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Example Body</label>

                                <div class="col-md-9">
                                    <label>
                                        <textarea v-model="createForm.example_body" class="form-control" />
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Example Response</label>
                                <div class="col-md-9">
                                    <label>
                                        <textarea v-model="createForm.example_response" class="form-control" />
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Docs URI</label>
                                <div class="col-md-9">
                                    <label>
                                        <input type="text" v-model="createForm.docs_uri" class="form-control" >
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                isLoading: true,
                isUploadingImage: false,
                apis: [],
                methods: ['GET','POST', 'PUT', "DELETE"],
                formLabel : '',
                imageUri: '',
                createForm: {
                    errors: [],
                    uri: '',
                    method: '',
                    id : '',
                    query_string: '',
                    headers: '',
                    example_body: '',
                    example_reponse: '',
                    docs_uri : '',
                    image_id : '',
                    image : ''
                }
            }
        },
        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getApis();

                $('#modal-create-api').on('shown.bs.modal', () => {
                    $('#create-api-name').focus();
                });
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

            /**
             * Show the form for creating new clients.
             */
            showCreateApiForm() {
                this.formLabel = "Create API"
                this.createForm.id = '';
                this.createForm.name = '';
                this.createForm.description = '';
                this.createForm.uri = '';
                this.createForm.method = '';
                this.createForm.query_string = '';
                this.createForm.headers = '';
                this.createForm.example_body = '';
                this.createForm.example_response = '';
                this.createForm.docs_uri = '';
                this.createForm.image_id = '';
                this.setImageData('');
                $('#modal-create-api').modal('show')
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                if(this.createForm.id != '') {
                    this.update();
                } else {
                    this.persistApi(
                        'post', '/api',
                        this.createForm, '#modal-create-api'
                    );
                }

            },

            /**
             * Edit the given api.
             */
            edit(api) {
                this.formLabel = "Edit API";
                this.createForm.id = api.id;
                this.createForm.name = api.name;
                this.createForm.description = api.description;
                this.createForm.uri = api.uri;
                this.createForm.method = api.method;
                this.createForm.query_string = api.query_string;
                this.createForm.headers = api.headers;
                this.createForm.example_body = api.example_body;
                this.createForm.example_response = api.example_response;
                this.createForm.docs_uri = api.docs_uri;
                this.setImageData(api.image_id);
                $('#modal-create-api').modal('show');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistApi(
                    'put', '/api/' + this.createForm.id,
                    this.createForm, '#modal-create-api'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistApi(method, uri, form, modal) {
                this.isLoading = true;
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getApis();

                        form.errors = [];

                        $(modal).modal('hide');
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data.errors));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(api) {
                axios.delete('/oauth/clients/' + client.id)
                    .then(response => {
                        this.getClients();
                    });
            },
            uploadImage(event) {
                this.isUploadingImage = true;
                this.setImageData('');
                let data = new FormData();
                data.append('name', 'formPic');
                data.append('file', event.target.files[0]);

                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                axios.post(
                    '/image/upload',
                    data,
                    config
                ).then(
                    response => {
                        // it is just uploading 1 image
                        this.setImageData(response.data[0].id)
                        this.isUploadingImage = false;
                    }
                ).catch(error => {
                    this.isUploadingImage = false;
                    if (typeof error.response.data === 'object') {
                        this.createForm.errors = _.flatten(_.toArray(error.response.data.message));
                    } else {
                        this.createForm.errors = ['Something went wrong updating image.'];
                    }
                })
            },
            setImageData(id) {
                this.createForm.image_id = id
                this.imageUri = "/image/get/" + id + "/80x80";
            }
        }
    }
</script>