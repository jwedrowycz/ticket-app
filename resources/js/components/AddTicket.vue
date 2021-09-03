<template>
    <div>
        <div class="row justify-content-center m-3">
            <div class="col-md-6 bg-white p-3">
                <h3 class="text-center">Wyślij zgłoszenie: {{ title }}</h3>
                <form @submit.prevent="addTicket">
                    <div class="form-group">
                        <label>Priorytet</label>
                        <!-- <b-form-select v-model="tickets.priority_id" :options="options"></b-form-select> -->
                        <select class="form-control" v-model="ticket.priority_id">
                            <option v-for="option in p_options" v-bind:value="option.id" :key="option.id">
                                {{ option.state }}
                            </option>
                        </select>
                        <div v-if="errors && errors.priority_id" class="text-danger">{{ errors.priority_id[0] }}</div>
                    </div>
                    <div class="form-group">
                        <label>Tytuł</label>
                        <input type="text" class="form-control" v-model="ticket.title">
                        <div v-if="errors && errors.title" class="text-danger">{{ errors.title[0] }}</div>
                    </div>
                    <div class="form-group">
                        <label>Krótki opis</label>
                        <textarea type="text" class="form-control" v-model="ticket.descr"></textarea>
                        <div v-if="errors && errors.descr" class="text-danger">{{ errors.descr[0] }}</div>
                    </div>
                    <div class="custom-file mb-3">
                        <input multiple type="file" id="customFile" class="custom-file-input" @change="onFileChange">
                        <label for="customFile" class="custom-file-label" lang="pl">
                          
                        </label>
                    </div>
                    <div v-for="(file) in files" class="" v-bind:key="file.key">
                        <p>{{ file.name }}</p>
                        <div v-if="errors && errors.files" class="text-danger">{{ errors.files[0] }}</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Dodaj zgłoszenie</button>
                </form>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        props: {
            category: String,
            title: String,
        },
        data() {
            return {
                ticket: {},
                p_options: [],
                loading: true,
                errors: {},
                files: {},
                file_urls: {}
            }
        },
        mounted () {
            axios.get('/api/priorities').then(response => {
                this.p_options = response.data;
            });
        },
        methods: {
            addTicket() {
                let formData = new FormData();
                if(this.ticket.title != null || this.ticket.priority_id != null || this.ticket.descr != null)
                {
                    formData.append('title',this.ticket.title);
                    formData.append('priority_id',this.ticket.priority_id);
                    formData.append('descr',this.ticket.descr);

                }
                for(let i=0; i<this.files.length; i++){
                        formData.append('files[]', this.files[i], this.files[i].name)
                    }
                    console.log(formData.get('files[]'))
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios
                        .post('/api/tickets/' + this.category, formData, {
                             headers: { 'Content-Type': 'multipart/form-data' }
                        })
                        .then(response => (
                            this.$root.$emit('ticket_added'),
                            this.makeToast('Pomyślnie dodano zgłoszenie', 'Zgłoszenie', 'success'),
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
                this.ticket.title = '';
                this.ticket.descr = '';
            },
            onFileChange(e){
                this.files = e.target.files;
                for(var i=0; i<this.files.length; i++)
                {
                    this.file_urls[i] = URL.createObjectURL(this.files[i]);
                }
            },
        }
        
    }
</script>