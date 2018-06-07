<template>
<div>
  <v-app>
    <v-layout>
      <v-flex xs12 sm6 offset-sm3>
        <div v-show="loader" style="text-align: center; width: 100%;">
          <v-progress-circular :size="50" indeterminate color="red"></v-progress-circular>
        </div>
        <v-card v-show="!loader">
          <v-layout>
            <v-flex xs12 sm6 offset-sm3>
              <div v-for="brand, key in brands" :key="brand.id">
                <v-layout>
                  <v-flex sm4><v-btn flat color="primary" darken-2 @click="openEditModal(key)">Edit</v-btn></v-flex>
                  <v-flex sm4>{{ brand.brand_name }}</v-flex>
                  <v-flex sm4><v-btn flat darken-2 color="error" @click="del(key, brand.id)">del</v-btn></v-flex>
                </v-layout>
              </div>
            </v-flex>
          </v-layout>
          <v-card-actions>
             <v-btn flat color="orange" @click="openAddModal">Add A Brand</v-btn>
           </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
    <v-snackbar
      :timeout="timeout"
      v-model="snackbar"
      bottom
      left
    >
      {{ message }}
      <v-btn flat color="white" @click.native="snackbar = false">Close</v-btn>
    </v-snackbar>

    <v-snackbar
      v-model="delLoader"
      bottom
      left
      color='black'
    >
      Deleting...
      <v-btn flat color="white" @click.native="snackbar = false">Close</v-btn>
    </v-snackbar>
  </v-app>
  <AddBrand :openAddRequest="openAdd" @alertRequest="alert" @closeRequest="close"></AddBrand>
  <EditBrand :openEditRequest="openEdit" @UpdateRequest="alertUp" @closeRequest="close"></EditBrand>
</div>
</template>

<script>
  let AddBrand = require('./AddBrand.vue')
  let EditBrand = require('./EditBrand.vue')
export default {
  components: {
    AddBrand, EditBrand
  },
  data() {
    return{
      brands: {},
      openAdd: false,
      openEdit: false,
      snackbar: false,
      delLoader: false,
      message: '',
      color: 'black',
      timeout: 5000,
      loader: false,
      errors: {},
    }
  },
  methods: {
    openAddModal() {
      this.openAdd = true
    },
    openEditModal(key) {
      this.$children[1].list = this.brands[key]
      this.openEdit = true
    },
    del(key,id) {
      if (confirm('Are you sure?')) {
        this.delLoader = true
        axios.delete(`/brands/${id}`)
        .then((response) => {
          this.delLoader = false
          this.brands.splice(key, 1)
          this.message='Brand deleted'
          this.color='black'
          this.snackbar = true
        })
      .catch((error) => {
          this.errors = error.response.data.errors
          // this.loader=false
      })
      }
    },
    alert() {
      this.message = 'Brand Added'
      this.color = 'black'
      this.snackbar = true
    },
    alertUp() {
      this.message = 'Brand Added'
      this.color = 'black'
      this.snackbar = true
    },
    close() {
      this.openAdd = this.openEdit = false
    }
  },
   mounted() {
      this.loader=true
      axios.post('getBrands')
      .then((response) => {
        this.brands = response.data
        this.loader=false
      })
      .catch((error) => {
          this.errors = error.response.data.errors
          this.loader=false
      })
   }
}
</script>

<style>
#looks{
   font-size: 120px;
   z-index: 1000;
   padding: 70px 0;
   margin: auto;
   margin-left: 390px;
}
.card__media__background.{
   background-attachment: fixed;
   content: woooo;
}
</style>