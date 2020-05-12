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
    .admin{
        color: green;
    }
    tbody tr:nth-child(odd) td{
        background-color: #c5cddd;
    }
</style>

<template>
    <div>
        <div class="card card-default">
            <div class="card-body">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        Users
                    </span>

                        <!--<a class="action-link" tabindex="-1" @click="showCreateAddressForm">
                            Create New User
                        </a> -->
                    </div>
                </div>
                <div class="card-body">
                    <p class="mb-0" v-if="users.length === 0 && isLoading != true">
                        You have not created any Users.
                    </p>
                    <div class="loading address" v-if="isLoading"></div>
                    <table class="table table-borderless mb-0" v-if="users.length > 0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Is Admin</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="user in users">
                            <!-- ID -->
                            <td style="vertical-align: middle;">
                                {{ user.id }}
                            </td>
                            <!-- Name -->
                            <td style="vertical-align: middle;">
                                {{ user.name }}
                            </td>

                            <!-- Email -->
                            <td style="vertical-align: middle;">
                                {{ user.email }}
                            </td>
                            <!-- is Admin -->
                            <td style="vertical-align: middle;">
                                <span v-if="user.isAdmin" class="admin fa fa-check"></span>
                            </td>
                            <!-- Mark as Admin -->
                            <td style="vertical-align: middle;">
                                <a class="action-link fa fa-user-tie" tabindex="-1" @click="markAsAdmin(user)">
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['authUser'],
        data() {
            return {
                isLoading: true,
                users: []
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
            markAsAdmin(user) {
                this.isLoading = true;

                axios.put('/markadmin/' + user.id + "/" + !user.isAdmin)
                    .then(response => {
                        this.getUsers();
                    });

            },
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getUsers();

                $('#modal-create-user').on('shown.bs.modal', () => {
                    $('#create-user-name').focus();
                });

                $('#modal-edit-client').on('shown.bs.modal', () => {
                    $('#edit-user-name').focus();
                });
            },
            getUsers() {
                axios.get('/users')
                    .then(response => {
                        this.users = response.data;
                        this.isLoading = false;
                    });
            }
        },
    }
</script>