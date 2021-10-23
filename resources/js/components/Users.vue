<template>
<div>
        <b-table :items="users.data" :fields="fields" :busy="isBusy" bordered head-variant="light" responsive="sm" class="bg-white" >
            <template #table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Ładowanie...</strong>
                </div>
            </template>
            <template #cell(actions)="row">
                 <b-button size="sm" v-b-modal="'update-modal' + row.item.id" variant="primary" class="mr-2">
                    Edytuj
                </b-button>
                <b-modal v-b-modal.update-modal+row.item.id>Czy na pewno chcesz usunąć tego użytkownika?</b-modal>
                <b-button size="sm" v-b-modal="'confirm-modal' + row.item.id" variant="danger" class="mr-2">
                    Usuń
                </b-button>
                <b-modal :id="'confirm-modal' + row.item.id" @ok="deleteUser(row.item.id)" >Czy na pewno chcesz usunąć tego użytkownika?</b-modal>
                 <b-modal
                    :id="'update-modal' + row.item.id"
                    ref="modal"
                    title="Edytuj użytkownika"
                    @ok="handleOk(row.item.id)"
                    >
                    <form ref="form" @submit.stop.prevent="updateUser(row.item.id)">
                        <b-form-group
                            label="Imię"
                            label-for="name-input"
                        >
                            <b-form-input
                                id="name-input"
                                v-model="row.item.name"
                                required
                            ></b-form-input>
                        </b-form-group>
                         <b-form-group
                            label="Email"
                            label-for="email-input"
                        >
                            <b-form-input
                                id="email-input"
                                v-model="row.item.email"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </form>
                </b-modal>
            </template>
        </b-table>
        <pagination :data="users" @pagination-change-page="loadUsers"></pagination>
    </div>
</template>

<script>
export default {
    props: {
        category: String
    },
    data() {
        return {
            users: {},
            loading: true,  
            state: '', 
            isBusy: false,
            status: 0,
            priority: 0,
            editedUser: {},
            fields: [
                    { key: 'id', label: 'Id' },
                    { key: 'name', label: 'Imię' },
                    { key: 'email', label: 'Email' },
                    { key: 'first_login', label: 'Pierwsze logowanie' },
                    { key: 'actions', label: 'Akcje' },
                ],
        }
    },
    mounted () {
        this.loadUsers();
        this.$root.$on('refresh_data', () => { 
            this.loadUsers();
        });
    },
    methods: {
        loadUsers(page = 1) {
                this.isBusy = true;
                axios.get('/api/admin/users', {
                        params: {
                            page: page
                        }
                    })
                    .then((response) => {
                        this.users = response.data;
                        this.isBusy = false;
                        localStorage.setItem('current_page', response.data.meta.current_page)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

        deleteUser(id) {
                axios.delete('/api/admin/users/'+id).then(response => {
                    this.loadUsers(localStorage.getItem('current_page'));
                    this.makeToast('Konta użytkownika zostało zdezaktywowane', 'Użytkownicy', 'info');
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        this.makeToast(this.errors, 'Błąd', 'danger');

                    }
                });
        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault()
            this.handleSubmit()
        },
        handleSubmit() {
            this.submittedNames.push(this.name)
            this.$nextTick(() => {
            this.$bvModal.hide('modal-prevent-closing')
            })
        },
        makeToast(msg, title, variant, position = 'b-toaster-bottom-right') {
                this.$root.$bvToast.toast(msg, {
                    title: title,
                    autoHideDelay: 5000,
                    variant: variant,
                    position: position,
                });
            },
            
    }
}
</script>