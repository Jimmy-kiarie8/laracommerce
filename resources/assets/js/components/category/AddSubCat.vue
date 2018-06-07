<template>
  <v-layout>
    <v-dialog v-model="openSubRequest" persistent max-width="500px">
     <v-card>
      <v-card-title>
        <span class="headline">Add A Sub-Category</span>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" @submit.prevent="submit">
          <v-container grid-list-xl fluid>
            <v-layout wrap>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="list.subcat_name "
                :rules="rules.name"
                color="blue darken-2"
                label="Category name"
                required
                ></v-text-field>
              </v-flex>
              <!-- <select class="custom-select custom-select-sm col-md-3" v-model="list.id">
                <label for="">Parent Category</label>
                <option v-for="category in cats" :value="category.id">{{category.category}}</option>
              </select> -->
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
  props: ['openSubRequest', 'cats'],
  data() {
    const defaultForm = Object.freeze({
      subcat_name: '',
      category_id: '',
    })
    return{
      form: Object.assign({}, defaultForm),
      errors: {},
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
      subcategories: {},
      list: {},
    }
  },

  computed: {
    formIsValid () {
      return (
        this.list.subcat_name
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
      axios.post('/subcats', this.$data.list)
      .then((response) => {
        // console.log(response);
        this.$emit('alertRequest')
        this.$parent.categories.subcats.push(response.data)  
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
      axios.post('getsubcategories')
      .then((response) => {
        this.subcategories = response.data
      })
      .catch((error) => {
          this.errors = error.response.data.errors
      })
   }
}
</script>
