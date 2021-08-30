<template>
<div>
    <div class="bg-white p-3 mb-3">
        <b-form-group label="Filtruj zgłoszenia" v-slot="{ ariaDescribedby }">
            <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="0" @change="filterTickets">Wszystkie</b-form-radio>
            <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="1" @change="filterTickets">Wysłane</b-form-radio>
            <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="2" @change="filterTickets">W realizacji</b-form-radio>
            <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="3" @change="filterTickets">Zrealizowane</b-form-radio>
        </b-form-group>
    </div>
        <b-table :items="tickets.data" :fields="fields" :busy="isBusy" bordered head-variant="light" responsive="sm" class="bg-white" >
            <template #table-busy>
                <div class="text-center text-danger my-2">
                <b-spinner class="align-middle"></b-spinner>
                <strong>Ładowanie...</strong>
                </div>
            </template>
            <template #cell(actions)="row">
                <b-button size="sm" @click="row.toggleDetails" class="mr-2">
                    <!-- {{ row.detailsShowing ? 'Schowaj' : 'Pokaż'}} Opis -->
                    Pokaż Opis
                </b-button>
                <template v-if="!adminUser">
                    <b-button size="sm" v-b-modal="'confirm-modal' + row.item.id" variant="danger" class="mr-2">
                        Usuń
                    </b-button>
                </template>
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
                selected: 0,
                isBusy: false,
        }
    }
}
</script>