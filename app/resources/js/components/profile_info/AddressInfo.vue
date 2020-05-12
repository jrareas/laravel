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
</style>

<template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        Addresses
                    </span>

                    <a class="action-link" tabindex="-1" @click="showCreateAddressForm">
                        Create New Address
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p class="mb-0" v-if="addresses.length === 0 && isLoading != true">
                    You have not created any Address.
                </p>
                <div class="loading address" v-if="isLoading"></div>
                <table class="table table-borderless mb-0" v-if="addresses.length > 0">
                    <thead>
                    <tr>
                        <th>Address</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="address in addresses">
                        <!-- ID -->
                        <td style="vertical-align: middle;">
                            {{ address.street_number }}&nbsp;{{ address.street_1 }}&nbsp;{{ address.street_2 }} <br>
                            {{ address.postal_code }} <br>
                            {{ address.province }},&nbsp;{{ address.country_name }}

                        </td>
                        <!-- Secret -->
                        <td style="vertical-align: middle;">

                        </td>

                        <!-- Edit Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link fa fa-edit" tabindex="-1" @click="edit(address)">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Address Modal -->
        <div class="modal fade" id="modal-create-address" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Create Address
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

                        <!-- Create Address Form -->
                        <form role="form">
                            <!-- street 1 -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Street</label>

                                <div class="col-md-9">
                                    <input id="create-address-street_1" type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.street_1">

                                </div>
                            </div>

                            <!-- Street 2 -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Street Complement</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="street_2"
                                           @keyup.enter="store" v-model="createForm.street_2">

                                    <span class="form-text text-muted">
                                        Unit #, Apartment #
                                    </span>
                                </div>
                            </div>

                            <!-- Street Number -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Street Number</label>

                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="text" v-model="createForm.street_number">
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <!-- Street Postal Code -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Postal Code</label>

                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="text" v-model="createForm.postal_code">
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <!-- Address Country -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Country</label>

                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <select v-if="countries.length > 0" v-model="createForm.country_id">
                                                <option id="-1"> Please Select ... </option>
                                                <option v-for="country in countries" v-bind:value="country.id" >{{ country.country_name }}</option>
                                            </select>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <!-- Province -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Province</label>

                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="text" v-model="createForm.province">
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Address Modal -->
        <div class="modal fade" id="modal-edit-address" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit Address
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Address Form -->
                        <form role="form">
                            <!-- street 1 -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Street</label>

                                <div class="col-md-9">
                                    <input id="edit-address-street_1" type="text" class="form-control"
                                           @keyup.enter="store" v-model="editForm.street_1">

                                </div>
                            </div>

                            <!-- Street 2 -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Street Complement</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="street_2"
                                           @keyup.enter="store" v-model="editForm.street_2">

                                    <span class="form-text text-muted">
                                        Unit #, Apartment #
                                    </span>
                                </div>
                            </div>

                            <!-- Street Number -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Street Number</label>

                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="text" v-model="editForm.street_number">
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <!-- Street Postal Code -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Postal Code</label>

                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="text" v-model="editForm.postal_code">
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <!-- Address Country -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Country</label>

                                <div class="col-md-9">
                                    <div class="dropdown">
                                        <label>
                                            <select v-if="countries.length > 0" v-model="editForm.country_id">
                                                <option > Please Select ... </option>
                                                <option v-for="country in countries" v-bind:value="country.id" >{{ country.country_name }}</option>
                                            </select>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <!-- Province -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Province</label>

                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="text" v-model="editForm.province">
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['authUser'],
        /*
         * The component's data.
         */
        data() {
            return {
                isLoading: true,
                addresses: [],
                countries: [],
                createForm: {
                    errors: [],
                    street_1: '',
                    street_2: '',
                    country_id: '',
                    country_name: '',
                    postal_code: '',
                    province: '',
                    user_id : this.authUser.id

                },

                editForm: {
                    errors: [],
                    street_1: '',
                    street_2: '',
                    country_id: '',
                    country_name: '',
                    postal_code: '',
                    province: '',
                    user_id : this.authUser.id
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
                this.getAddresses();

                $('#modal-create-address').on('shown.bs.modal', () => {
                    $('#create-address-street_1').focus();
                });

                $('#modal-edit-client').on('shown.bs.modal', () => {
                    $('#edit-address-street_1').focus();
                });
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getAddresses() {
                axios.get('/address?user_id=' + this.authUser.id)
                    .then(response => {
                        this.addresses = response.data;
                        this.isLoading = false;
                        $(".loading .address").hide();
                    });
            },

            /**
             * Show the form for creating new clients.
             */
            showCreateAddressForm() {
                this.getCountries();
                $('#modal-create-address').modal('show');
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/address',
                    this.createForm, '#modal-create-address'
                );
            },

            getCountries() {
                if(this.countries.length == 0) {
                    axios['get']("/countries")
                        .then(response => {
                            this.countries = response.data
                        })
                        .catch(error => {
                            if (typeof error.response.data === 'object') {
                                form.errors = _.flatten(_.toArray(error.response.data.errors));
                            } else {
                                form.errors = ['Something went wrong. Please try again.'];
                            }
                        });
                }
            },

            /**
             * Edit the given client.
             */
            edit(address) {
                this.getCountries();
                this.editForm.id = address.id;
                this.editForm.street_1 = address.street_1;
                this.editForm.street_2 = address.street_2;
                this.editForm.street_number = address.street_number;
                this.editForm.postal_code = address.postal_code;
                this.editForm.country_id = address.country_id;
                this.editForm.province = address.province;

                $('#modal-edit-address').modal('show');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', 'address' + this.editForm.id,
                    this.editForm, '#modal-edit-client'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                this.isLoading = true;
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getAddresses();

                        form.name = '';
                        form.redirect = '';
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
            destroy(address) {
                axios.delete('/oauth/clients/' + client.id)
                    .then(response => {
                        this.getClients();
                    });
            }
        }
    }
</script>