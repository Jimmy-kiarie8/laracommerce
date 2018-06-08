<template>
  <v-layout row justify-center>
    <v-dialog v-model="openDetail" persistent max-width="800">
      <v-card>
        <v-flex sm10>
        <v-card-title class="headline">{{list.title}}</v-card-title>
        <v-divider></v-divider>  
        <v-layout row>
          <v-flex sm5 offset-sm1>
            <v-card-media :src="list.image" height="400px"></v-card-media>          
          </v-flex>

          <v-flex sm5 offset-sm1>
            Details
            <p>{{ list.description }}</p>        
            <v-divider></v-divider> 
            <p>Price: {{list.price}}</p>
            <!-- <p>Brand: {{list.brand.brand_name}}</p> -->
          </v-flex>
        </v-layout>
        
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat="flat" @click.native="close">Close</v-btn>
          <v-btn flat color="orange" dark @click="add"><v-icon>shopping_cart </v-icon>Add Cart</v-btn>
        </v-card-actions>
      </v-flex>
      </v-card>

      <v-snackbar
        :timeout="timeout"
        v-model="snackbar"
        bottom
        left
      >
        {{ message }}
        <v-btn flat color="white" @click.native="snackbar = false">Close</v-btn>
      </v-snackbar>
    </v-dialog>
  </v-layout>
</template>

<script>
export default {
  props: ['openDetail'],
  data () {
    return {
      list: {},
      snackbar: false,
      timeout: 5000,
      message: '',
    }
  },
  methods: {
    add() {
      // console.log('adding...');
      axios.post(`addcart/${this.list.id}`, this.$data.list)
      .then((response) => {
        this.message = 'added'
        this.color = 'black'
        this.snackbar = true
      }) 
    .catch((error) => {
      this.errors = error.response.data.errors
      this.message = 'error'
      this.color = 'red'
      this.snackbar = true
    })
    },
    close() {
      this.$emit('closeRequest')
    }
  }
}
</script>
