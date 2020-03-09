<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div>
        <div class="card card-default">
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <thead>
                    <tr >
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr >
                        <!-- ID -->
                        <td style="vertical-align: middle;">
                            {{ user.name }}
                        </td>

                        <!-- Name -->
                        <td style="vertical-align: middle;">
                            {{ user.email }}
                        </td>

                        <!-- Edit Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link fa fa-edit" tabindex="-1" @click="edit(user)">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Edit User Modal -->
        <div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit User
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

                        <!-- Edit User Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input id="edit-user-name" type="text" class="form-control"
                                           @keyup.enter="update" v-model="editForm.name">

                                    <span class="form-text text-muted">
                                        Your name
                                    </span>
                                </div>

                                <label class="col-md-3 col-form-label">Email</label>
                                <div class="col-md-9">

                                    <input id="edit-user-email" type="text" class="form-control"
                                           @keyup.enter="update" v-model="editForm.email">
                                    <span class="form-text text-muted">
                                        Your Email Address
                                    </span>

                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            Save Changes
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
                user_id: this.authUser.id,
                user: {},

                createForm: {
                    errors: [],
                    name: '',
                    redirect: '',
                    confidential: true
                },

                editForm: {
                    errors: [],
                    name: '',
                    email: ''
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
                this.getUser();

                $('#modal-create-user').on('shown.bs.modal', () => {
                    $('#create-user-name').focus();
                });

                $('#modal-edit-user').on('shown.bs.modal', () => {
                    $('#edit-user-name').focus();
                });
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getUser() {
                axios.get('/user/' + this.authUser.id)
                    .then(response => {
                        this.user = response.data
                        this.$nextTick()
                    });
            },

            /**
             * Show the form for creating new clients.
             */
            showCreateClientForm() {
                $('#modal-create-client').modal('show');
            },

            /**
             * Edit the given user.
             */
            edit(user) {
                this.editForm.id = user.id;
                this.editForm.name = user.name;
                this.editForm.email = user.email;

                $('#modal-edit-user').modal('show');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistUser(
                    'put', '/user/' + this.editForm.id,
                    this.editForm, '#modal-edit-user'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistUser(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getUser();

                        form.name = '';
                        form.email = '';
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
        }
    }
</script>