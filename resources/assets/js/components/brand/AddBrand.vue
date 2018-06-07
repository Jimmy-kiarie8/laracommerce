<template>
  <v-layout>
    <v-dialog v-model="openAddRequest" persistent max-width="500px">
     <v-card>
      <v-card-title>
        <span class="headline">Add A Brand</span>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" @submit.prevent="submit">
          <v-container grid-list-xl fluid>
            <v-layout wrap>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="form.brand_name "
                :rules="rules.name"
                color="blue darken-2"
                label="Brand name"
                required
                ></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <v-card-actions>
            <v-btn flat @click="resetForm">Close</v-btn>
            <v-spacer></v-spacer>
            <v-btn
            :disabled="!formIsValid"
            flat
            color="primary"
            @click="save"
            >Add</v-btn>
          </v-card-actions>
        </v-form>
      </v-card-text>

    </v-card>
  </v-dialog>
</v-layout>
</template>

<script>
export default {
  props: ['openAddRequest'],
  data() {
    const defaultForm = Object.freeze({
      brand_name: '',
    })
    return{
      form: Object.assign({}, defaultForm),
      errors: {},
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },

  computed: {
    formIsValid () {
      return (
        this.form.brand_name
        )
    }
  },

  methods: {
    resetForm () {
      this.form = Object.assign({}, this.defaultForm)
      this.$refs.form.reset()
      this.close()
    },
    save () {
      axios.post('/brands', this.$data.form)
      .then((response) => {
        // console.log(response);
        this.$emit('alertRequest')
        this.$parent.brands.push(response.data)
        this.resetForm()
        this.close()
      })
      .catch((error) => {
        this.errors = error.response.data.errors
      })
    },
    close() {
      this.$emit('closeRequest')
    }
  },
  mounted() {
    console.log('Component mounted.')
  }
}
</script>
