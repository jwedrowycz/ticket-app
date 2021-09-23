<template>
<div>
    <div class="bg-white p-3 mb-3">
        <div class="row">
            <div class="col-lg-3">
                <b-form-group label="Status zgłoszenia" v-slot="{ ariaDescribedby }">
                    <b-form-radio v-model="status" :aria-describedby="ariaDescribedby" name="filter-status-radios" value="0" @change="filterTickets">Wszystkie</b-form-radio>
                    <b-form-radio v-model="status" :aria-describedby="ariaDescribedby" name="filter-status-radios" value="1" @change="filterTickets">Wysłane</b-form-radio>
                    <b-form-radio v-model="status" :aria-describedby="ariaDescribedby" name="filter-status-radios" value="2" @change="filterTickets">W realizacji</b-form-radio>
                    <b-form-radio v-model="status" :aria-describedby="ariaDescribedby" name="filter-status-radios" value="3" @change="filterTickets">Zrealizowane</b-form-radio>
                </b-form-group>
            </div>
            <div class="col-lg-3">
                <b-form-group label="Priorytet zgłoszenia" v-slot="{ ariaDescribedby }">
                    <b-form-radio v-model="priority" :aria-describedby="ariaDescribedby" name="filter-priority-radios" value="0" @change="filterTickets">Wszystkie</b-form-radio>
                    <b-form-radio v-model="priority" :aria-describedby="ariaDescribedby" name="filter-priority-radios" value="1" @change="filterTickets">Niski</b-form-radio>
                    <b-form-radio v-model="priority" :aria-describedby="ariaDescribedby" name="filter-priority-radios" value="2" @change="filterTickets">Średni</b-form-radio>
                    <b-form-radio v-model="priority" :aria-describedby="ariaDescribedby" name="filter-priority-radios" value="3" @change="filterTickets">Wysoki</b-form-radio>
                </b-form-group>
            </div>
        </div>
        
    </div>
        <pagination 
            :data="tickets" 
            @pagination-change-page="loadTickets"
            :limit="10"
        >
        </pagination>
        <b-table :items="tickets.data" :fields="fields" :busy="isBusy" bordered head-variant="light" responsive="sm" class="bg-white" >
            <template #table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Ładowanie...</strong>
                </div>
            </template>
            <template #cell(actions)="row">
                <b-button size="sm" @click="row.toggleDetails" class="mb-1">
                    {{ row.detailsShowing ? 'Schowaj' : 'Pokaż'}} Opis
                </b-button>
                <template v-if="authUser == row.item.user_id || adminUser">
                    <b-button block size="sm" v-b-modal="'confirm-modal' + row.item.id" variant="danger" class="mb-1">
                        Usuń
                    </b-button>
                </template>
                <template v-if="adminUser">
                    <template v-if="row.item.status == 'Wysłane'">
                        <b-button block size="sm" variant="info" @click="pursueTicket(row.item.id)" class="mb-1">
                            Realizuj
                        </b-button>
                    </template>
                    <template v-if="row.item.status == 'W realizacji'">
                        <b-button block size="sm" variant="success" @click="completeTicket(row.item.id)" class="mb-1">
                            Zakończ
                        </b-button>
                    </template>
                </template>
                <b-modal :id="'confirm-modal' + row.item.id" @ok="deleteTicket(row.item.id)" >Czy na pewno chcesz usunąć te zgłoszenie?</b-modal>
            </template>
            <template #row-details="row">
                <p><b>Opis: </b>{{ row.item.descr }}</p>
                <div class="d-flex flex-row" v-if="row.item.files.length">
                    <p><b>Załączniki: </b></p>
                    <div v-for="file in row.item.files" v-bind:key="file">
                        <img v-bind:key="file.filename" class="thumbnail p-2" :src="'/storage/' + file.filename">
                    </div>
                </div>
                <div class="my-2" v-if="authUser == row.item.user_id || adminUser">
                    <b-button v-b-modal.modal-comment variant="outline-secondary">Dodaj komentarz</b-button>
                    <comment-form-component :ticket_title="row.item.title" :ticket_id="row.item.id"></comment-form-component>
                </div>
                <div class="d-flex flex-column" v-if="row.item.comments.length">
                <h5>Komentarze</h5>
                    <div v-for="comment in row.item.comments" v-bind:key="comment">
                        <div class="bg-light p-3 mb-2 rounded d-flex justify-content-between" >
                            <div>
                                <b>{{ comment.user }}</b>:&nbsp;{{ comment.content }}
                            </div>
                            <div>
                                <small>{{ comment.created_at }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </b-table>
        <pagination 
            :data="tickets" 
            @pagination-change-page="loadTickets"
            :limit="10"
        >
        </pagination>
    </div>
</template>

<script>
export default {
    props: {
        category: String
    },
    data() {
        return {
            tickets: {},
            loading: true,  
            state: '', 
            isBusy: false,
            status: 0,
            priority: 0,
            fields: [
                    { key: 'id', label: 'Id zgłoszenia' },
                    { key: 'title', label: 'Tytuł' },
                    { key: 'created_at', label: 'Data zgłoszenia'},
                    { key: 'priority', label: 'Priorytet', tdClass: "addTdClass"},
                    { key: 'category', label: 'Kategoria', },
                    { key: 'status', label: 'Status' },
                    { key: 'user', label: 'Użytkownik' },
                    { key: 'user_id', tdClass: 'd-none', thClass: 'd-none' },
                    { key: 'actions', label: 'Akcje' },
                ],
            adminUser: window.adminUser,
            authUser: window.authUser
        }
    },
    mounted () {
        this.loadTickets();
        this.$root.$on('refresh_data', () => { 
            this.loadTickets();
        });
    },
    methods: {
        loadTickets(page = 1) {
                this.isBusy = true;
                axios.get('/api/tickets/' + this.category, { params: {
                    page: page,
                    status: this.status,
                    priority: this.priority,
                    
                } })
                    .then((response) => {
                        this.tickets = response.data;
                        this.isBusy = false;
                        localStorage.setItem('current_page', response.data.meta.current_page)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

        addTdClass(value, key, item) {
                return item.color
            },

        deleteTicket(id) {
            axios.get('sanctum/csrf-cookie').then(response => {
                axios.delete('/api/tickets/'+id);
                this.loadTickets(localStorage.getItem('current_page'));
                this.makeToast('Zgłoszenie zostało usunięte', 'Zgłoszenia', 'info');
            }).catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                    this.makeToast(this.errors, 'Błąd', 'danger');

                }
            });
        },
        pursueTicket(id) {
                axios.put('/api/admin/tickets/pursue/'+id).then(response => {
                    this.makeToast('Zgłoszenie jest w realizacji', 'Zgłoszenia', 'info');
                    this.loadTickets(localStorage.getItem('current_page'));
                });
        },
        completeTicket(id) {
                axios.put('/api/admin/tickets/complete/'+id).then(response => {
                    this.makeToast('Zgłoszenie zostało zrealizowane', 'Zgłoszenia', 'success');
                    this.loadTickets(localStorage.getItem('current_page'));
                });
         
        },
        filterTickets() {
                this.isBusy = true;
                axios.get('http://127.0.0.1:8000/api/tickets/' + this.category, { params: {
                        status: this.status,
                        priority: this.priority,
                        page: 1,
                    }
                })
                .then(response => { 
                    this.tickets = response.data; 
                    this.isBusy = false;
                });
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