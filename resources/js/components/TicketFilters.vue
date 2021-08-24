<template>
     <b-form-group label="Filtruj zgłoszenia" v-slot="{ ariaDescribedby }">
        <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="1" @change="filterTickets">Wysłane</b-form-radio>
        <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="2" @change="filterTickets">W realizacji</b-form-radio>
        <b-form-radio v-model="selected" :aria-describedby="ariaDescribedby" name="filter-radios" value="3" @change="filterTickets">Zakończone</b-form-radio>
    </b-form-group>
</template>

<script>
export default {
    data() {
        return {
            
        }
    }
}
</script>