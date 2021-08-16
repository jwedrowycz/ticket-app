<template>
    <table class="table border">
        <thead class="thead">
            <tr>
                <th scope="col">Id zgłoszenia</th>
                <th scope="col">Tytuł</th>
                <th scope="col">Krótki opis</th>
                <th scope="col">Priorytet</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody :class="{'loading':loading}">
            <tr v-for="ticket in tickets.data" :key="ticket.id">
                <td>{{ ticket.id }}</td>
                <td>{{ ticket.title }}</td>
                <td>{{ ticket.descr }}</td>
                <td :class="ticket.color" >{{ ticket.priority }}</td>
                <td>{{ ticket.status }}</td>
            </tr>
        </tbody>
    </table>    
</template>

<script>
export default {
    data() {
        return {
            tickets: {},
            loading: true,   
        }
    },
    mounted () {
        this.loadTickets();
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
    }
}
</script>