 <template>
    <b-modal id="modal-comment" title="Dodaj komentarz"  @ok="handleOk">
         <form @submit.prevent="handleSubmit">
                    <div class="form-group">
                        <h3>
                            {{ ticket_title }}
                        </h3>
                        <label for="message-text" class="col-form-label">Komentarz<small class="text-danger">*</small></label>
                        <textarea class="form-control" id="message-text" v-model="fields.content"></textarea>
                        <div v-if="errors && errors.content" class="text-danger">{{ errors.content[0] }}</div>
                    </div>
                </form>
    </b-modal> 
 </template>

<script>
  export default {
    props: [
        'ticket_title', 'ticket_id'
    ],
    data() {
      return {
            loading: true,
            fields: {},
            success: false,
            errors: {}
      }
    },
    mounted() {
        this.fields.ticket_id = this.ticket_id;
    },
    methods: {
        handleOk(bvModalEvt) {
             bvModalEvt.preventDefault()
                this.handleSubmit();
        },
        handleSubmit() {
            axios.post('/api/tickets/'+ this.ticket_id +'/comments', this.fields).then(response => {
                this.fields = {};
                this.success = true;
                this.errors = {};
                this.$root.$emit('refresh_data'),
                this.makeToast('Komentarz został dodany', 'Menadżer Zadań', 'success');
                this.fields.is_private = 0;
                this.$refs['modal-comment'].hide();
            }).catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                } else {
                    this.makeToast('Wystąpił nieoczekiwany błąd', 'Menadżer Zadań', 'danger');
                }
            });
        },
        makeToast(msg, title, variant, position = 'b-toaster-bottom-right') {
            this.$root.$bvToast.toast(msg, {
                title: title,
                autoHideDelay: 7000,
                variant: variant,
                position: position,
            });
        },
    },
  }
</script>