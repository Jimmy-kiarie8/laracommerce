<template>
  <v-layout>
    <v-dialog v-model="openEditRequest" persistent max-width="500px">
     <v-card>
      <v-card-title>
        <span class="headline">Edit {{ list.category }}'s Category</span>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" @submit.prevent>
          <v-container grid-list-xl fluid>
            <v-layout wrap>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="list.category "
                :rules="rules.name"
                color="blue darken-2"
                label="Category name"
                required
                ></v-text-field>
              </v-flex>

              <select class="custom-select custom-select-sm col-md-3" v-model="list.parent">
                <label for="">Parent</label>
                <option value="0">Parent</option>
                <option v-for="category in categories" :value="category.id">{{category.category}}</option>
              </select>
            </v-layout>
          </v-container>
          <v-card-actions>
            <v-btn flat @click="close">Close</v-btn>
            <v-spacer></v-spacer>
            <v-btn
            :disabled="!formIsValid"
            flat
            color="primary"
            @click="update"
            >Update</v-btn>
          </v-card-actions>
        </v-form>
      </v-card-text>

    </v-card>
  </v-dialog>
</v-layout>
</template>

<script>
export default {
  props: ['openEditRequest', 'cats'],
  data() {
    return{
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
      errors: {},
      list: {}, 
      categories: {},
    }
  },

  computed: {
    formIsValid () {
      return (
        this.list.category
        )
    }
  },

  methods: {
    update () {
      axios.patch(`/categories/${this.list.id}`, this.$data.list)
      .then((response) => {
        console.log(response);
        this.$emit('alertRequest')
        // this.resetForm()
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
