<template>
    <b-table :items="tickets.data" :fields="fields" bordered head-variant="light" responsive="sm" class="bg-white">

        <template #cell(actions)="row">
            <b-button size="sm" @click="row.toggleDetails" class="mr-2">
                {{ row.detailsShowing ? 'Schowaj' : 'Pokaż'}} Opis
            </b-button>
            <b-button size="sm" v-b-modal="'confirm-modal' + row.item.id" variant="danger" class="mr-2">
                Usuń
            </b-button>
            <b-modal :id="'confirm-modal' + row.item.id" @ok="deleteTicket(row.item.id)" >Czy na pewno chcesz usunąć te zgłoszenie?</b-modal>
        </template>

         <template #row-details="row">
             <p><b>Opis: </b>{{ row.item.descr }}</p>
         </template>
    </b-table>
        
    
</template>

<script>
export default {
    data() {
        return {
            tickets: {},
            loading: true,   
            fields: [
                { key: 'id', label: 'Id zgłoszenia' },
                { key: 'title', label: 'Tytuł' },
                { key: 'created_at', label: 'Data zgłoszenia'},
                { key: 'priority', label: 'Priorytet', tdClass: "addTdClass"},
                { key: 'status', label: 'Status' },
                { key: 'actions', label: 'Akcje' },

                ]
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
                }
            });
    },
    }
}
</script>