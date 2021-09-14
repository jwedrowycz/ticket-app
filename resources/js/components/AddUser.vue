<template>
    <div>
        <div class="row justify-content-center m-3">
            <div class="col-md-3 bg-white p-3">
                <h3 class="text-center">Dodaj użytkownika</h3>
                <form @submit.prevent="addUser">
                    <div class="form-group">
                        <label>Imię i nazwisko</label>
                        <input type="text" class="form-control" v-model="user.name">
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>
                    <div class="form-group">
                        <label>Adres email</label>
                        <input type="email" class="form-control" v-model="user.email">
                        <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                    </div>
                    <div class="form-group">
                        <label>Hasło</label>
                        <input type="password" class="form-control" v-model="user.password">
                        <div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>
                    </div>
                    <div class="form-group">
                        <label>Powtórz hasło</label>
                        <input type="password" class="form-control" v-model="user.password_confirmation">
                        <div v-if="errors && errors.password_confirmation" class="text-danger">{{ errors.password_confirmation[0] }}</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Zatwierdź</button>
                </form>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        props: {
        },
        data() {
            return {
                user: {},
                loading: true,
                errors: {},

            }
        },
        methods: {
            addUser() {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios
                        .post('/api/register-user',  this.user, {
                             headers: { 'Accept': 'application/json' }})
                        .then(response => (
                            // this.$root.$emit('refresh_data'),
                            this.makeToast('Pomyślnie dodano użytkownika', 'Użytkownik', 'success'),
                            this.resetInput()
                        ))
                        .catch(error =>  {
                            if (error.response.status == 422) {
                                this.errors = error.response.data.errors;
                            } else {
                                this.makeToast('Wystąpił nieoczekiwany błąd', 'Ticket-App', 'danger');
                            }
                        })
                        .finally(() => this.loading = false);
                }
            )},
            makeToast(msg, title, variant, position = 'b-toaster-bottom-right') {
                this.$root.$bvToast.toast(msg, {
                    title: title,
                    autoHideDelay: 7000,
                    variant: variant,
                    position: position,
                });
            },
            resetInput() {
                this.user.name = '';
                this.user.email = '';
                this.user.password = '';
                this.user.password_confirmation = '';
            },
        }
        
    }
</script>