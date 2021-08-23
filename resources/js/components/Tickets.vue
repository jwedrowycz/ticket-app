<template>
<div :class="{'loading':loading}">
        <b-form-group label="Filtruj zgłoszenia" v-slot="{ ariaDescribedby }">
            <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="1" @change="filterTickets">Wysłane</b-form-radio>
            <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="2" @change="filterTickets">W realizacji</b-form-radio>
            <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="3" @change="filterTickets">Zakończone</b-form-radio>
        </b-form-group>
        <!-- <b-form-checkbox
            id="checkbox_only_completed"
            v-model="filters.completed"
            value="true"
            unchecked-value="false"
            @change="filterTasks">
            Tylko ukończone zadania
        </b-form-checkbox> -->
        <b-table :items="tickets.data" :fields="fields" bordered head-variant="light" responsive="sm" class="bg-white" >

            <template #cell(actions)="row">
                <b-button size="sm" @click="row.toggleDetails" class="mr-2">
                    <!-- {{ row.detailsShowing ? 'Schowaj' : 'Pokaż'}} Opis -->
                    Pokaż Opis
                </b-button>
                <b-button size="sm" v-b-modal="'confirm-modal' + row.item.id" variant="danger" class="mr-2">
                    Usuń
                </b-button>
                <template v-if="adminUser && row.item.status == 'Wysłane'">
                    <b-button size="sm" variant="info" @click="pursueTicket(row.item.id)">
                        Realizuj
                    </b-button>
                </template>
                <template v-if="adminUser && row.item.status == 'W realizacji'">
                    <b-button size="sm" variant="success" @click="completeTicket(row.item.id)">
                        Zakończ
                    </b-button>
                </template>
                <b-modal :id="'confirm-modal' + row.item.id" @ok="deleteTicket(row.item.id)" >Czy na pewno chcesz usunąć te zgłoszenie?</b-modal>
            </template>

            <template #row-details="row">
                <p><b>Opis: </b>{{ row.item.descr }}</p>
            </template>
            
        </b-table>
        <pagination :data="tickets" @pagination-change-page="loadTickets"></pagination>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tickets: {},
            loading: true,  
            state: '', 
            selected: '',
            fields: [
                { key: 'id', label: 'Id zgłoszenia' },
                { key: 'title', label: 'Tytuł' },
                { key: 'created_at', label: 'Data zgłoszenia'},
                { key: 'priority', label: 'Priorytet', tdClass: "addTdClass"},
                { key: 'status', label: 'Status' },
                { key: 'actions', label: 'Akcje' },

                ],
            adminUser: window.adminUser,
        }
    },
    mounted () {
        this.loadTickets();
         this.$root.$on('ticket_added', () => {
               this.loadTickets();
            });
    },
    methods: {
        loadTickets(page = 1) {
                axios.get('/api/tickets?page=' + page)
                    .then((response) => {
                        this.tickets = response.data;
                        this.loading = false;
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
                this.loadTickets();
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
        filterTickets(page = localStorage.getItem('current_page')) {
                // this.loading = true;
                axios.get('http://127.0.0.1:8000/api/tickets?page=' + page + '?tickets=' + this.selected)
                .then(response => { 
                    // this.tickets = response.data; 
                    // this.loading = false;
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