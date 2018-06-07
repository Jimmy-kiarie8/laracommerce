<template>
  <v-layout>
    <v-dialog v-model="openEditRequest" persistent max-width="500px">
     <v-card>
      <v-card-title>
        <span class="headline">Add A Brand</span>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" @submit.prevent>
          <v-container grid-list-xl fluid>
            <v-layout wrap>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="list.brand_name "
                :rules="rules.name"
                color="blue darken-2"
                label="Brand name"
                required
                ></v-text-field>
              </v-flex>
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
  props: ['openEditRequest'],
  data() {
    return{
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
      errors: {},
      list: {}, 
    }
  },

  computed: {
    formIsValid () {
      return (
        this.list.brand_name
        )
    }
  },

  methods: {
    update () {
      axios.patch(`/brands/${this.list.id}`, this.$data.list)
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
    console.log('Component mounted.')
  }
}
</script>
