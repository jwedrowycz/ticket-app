<template>
    <div>
        <div class="row justify-content-center m-3">
            <div class="col-md-6 bg-white p-3">
                <h3 class="text-center">Wyślij zgłoszenie: {{ title }}</h3>
                <form @submit.prevent="addTicket">
                    <div class="form-group">
                        <label>Priorytet</label>
                        <select class="form-control" v-model="ticket.priority_id">
                        <option v-for="option in p_options" v-bind:value="option.id" :key="option.id">
                            {{ option.state }}
                        </option>
                        </select>
                        <div v-if="errors && errors.state" class="text-danger">{{ errors.state[0] }}</div>
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
                     <div id="preview" class="preview-img">
                         <div v-for="(value, img) in file_props" class="" v-bind:key="value">
                            <img :src="img" />
                            <small>{{ value }}</small>   
                         </div>
                    </div>
                    {{ file_props }}

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
                s_options: {},
                selected: null,
                p_options: [],
                loading: true,
                errors: {},
                files: {},
                file_props: {}
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
                formData.append('title',this.ticket.title);
                formData.append('priority_id',this.ticket.priority_id);
                formData.append('descr',this.ticket.descr);
                formData.append('files', this.files);
        
                for(let i=0; i<file.length; i++){
                        formData.append('file[]', file[i])
                    }
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios
                        .post('/api/tickets/' + this.category, formData, {
                             headers: { 'content-type': 'multipart/form-data' }
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
                                this.makeToast('Wystąpił nieoczekiwany błąd', 'Menadżer Zadań', 'danger');
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
                    this.file_props[this.files[i].name] = URL.createObjectURL(this.files[i]);
                }
                console.log(this.file_props);
            },
        }
        
    }
</script>