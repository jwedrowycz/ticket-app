<template>
    <div>
        <div class="row justify-content-center m-3">
            <div class="col-md-6 bg-white p-3">
                <h3 class="text-center">Wyślij zgłoszenie</h3>
                <form @submit.prevent="addTicket">
                    <div class="form-group">
                        <label>Priorytet</label>
                        <select class="form-control" v-model="ticket.priority_id">
                        <option v-for="option in p_options" v-bind:value="option.id" :key="option.id">
                            {{ option.state }}
                        </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nazwa</label>
                        <input type="text" class="form-control" v-model="ticket.title">
                    </div>
                    <div class="form-group">
                        <label>Krótki opis</label>
                        <textarea type="text" class="form-control" v-model="ticket.descr"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Dodaj zgłoszenie</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ticket: {},
                // p_options: {},
                s_options: {},
                selected: null,
                p_options: []
                }
        },
        mounted () {
            axios.get('/api/priorities').then(response => {
                this.p_options = response.data;
            })
        },
        methods: {
            addTicket() {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios
                        .post('/api/tickets', this.ticket)
                        .then(response => (
                            console.log(response.data)
                        ))
                        .catch(error => console.log(error))
                        .finally(() => this.loading = false);
                }
            )},
            makeToast(msg, title, variant) {
                this.$root.$bvToast.toast(msg, {
                    title: title,
                    autoHideDelay: 7000,
                    variant: variant,
                });
            }
        }
        
    }
</script>