<template>
  <v-layout>
    <v-dialog v-model="openAddRequest" persistent max-width="500px">
     <v-card>
      <v-card-title>
        <span class="headline">Add A Category</span>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" @submit.prevent="submit">
          <v-container grid-list-xl fluid>
            <v-layout wrap>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="form.category "
                :rules="rules.name"
                color="blue darken-2"
                label="Category name"
                required
                ></v-text-field>
              </v-flex>
              <!-- <select class="custom-select custom-select-sm col-md-3" v-model="form.parent">
                <label for="">Parent</label>
                <option value="0">Parent</option>
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
  props: ['openAddRequest', 'cats'],
  data() {
    const defaultForm = Object.freeze({
      category: '',
      parent: '',
    })
    return{
      form: Object.assign({}, defaultForm),
      errors: {},
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
      categories: {},
    }
  },

  computed: {
    formIsValid () {
      return (
        this.form.category &&
        this.form.parent
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
      axios.post('/categories', this.$data.form)
      .then((response) => {
        // console.log(response);
        this.$emit('alertRequest')
        if (response.data.parent === "0") {
          this.$parent.categories.push(response.data)          
        }else{
          this.$parent.subCategories.push(response.data)          
        }
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
      axios.post('getcategories')
      .then((response) => {
        this.categories = response.data
      })
      .catch((error) => {
          this.errors = error.response.data.errors
      })
   }
}
</script>
