<template>
  <div>
    <v-app>
      <v-layout>
        <v-flex xs12 sm8 offset-sm2>
          <v-card>
            <div v-show="loader" style="text-align: center; width: 100%;">
              <v-progress-circular :size="50" indeterminate color="red"></v-progress-circular>
            </div>
            <v-layout row v-show="!loader">
                <v-btn flat color="orange" @click="openAddModal">Add A Category</v-btn>
              <v-divider></v-divider>
              <v-flex xs12 sm10 offset-sm1>
                <table class="table table-bordered table-stripped table-hover">
                  <thead>
                    <th>Category</th>
                    <th>Parent</th>
                    <th>#</th>
                  </thead>

                  <tbody v-for="category, key in categories" :key="category.id">
                    <tr style="background: #eee">
                      <td>{{ category.category }}</td>
                      <td>parent</td>
                      <td>
                        <v-btn flat color="primary" @click="openEditModal(key)">edit</v-btn>
                        <v-btn flat color="success" @click="openaddSubModal(key)">Add Sub</v-btn>
                        <v-btn flat color="error">delete</v-btn>
                      </td>
                    </tr>
                    <tr v-for="subs in category.subcats">
                      <td>{{ subs.subcat_name }}</td>
                      <td>{{ category.category }}</td>
                      <td>
                        <v-btn flat color="primary" @click="openSubModal(key)">edit</v-btn>
                        <!-- <v-btn flat color="success" @click="openaddSubModal(key)">Add Sub</v-btn> -->
                        <v-btn flat color="error" @click="openaddSubModal(key)">delete</v-btn>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </v-flex>

            </v-layout>
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
<AddCategory :openAddRequest="openAdd" @alertRequest="alert" @closeRequest="close" :cats="categories"></AddCategory>
<EditCategory :openEditRequest="openEdit" @UpdateRequest="alertUp" @closeRequest="close" :cats="categories"></EditCategory>
<AddSubCat :openSubRequest="opensub" @alertRequest="alert" @closeRequest="close" :cats="categories"></AddSubCat>
</div>
</template>

<script>
let AddCategory = require('./AddCategory.vue')
let AddSubCat = require('./AddSubCat.vue')
let EditCategory = require('./EditCategory.vue')
export default {
  components: {
    AddCategory, EditCategory, AddSubCat
  },
  data() {
    return{
      categories: {
        subcats: {}
      },
      subCategories: {},
      openAdd: false,
      openEdit: false,
      opensub: false,
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
      this.$children[1].list = this.categories[key]
      this.openEdit = true
    },
    openSubModal(key) {
      this.$children[2].list = this.subCategories[key]
      this.openEdit = true
    },
    openaddSubModal(key) {
      this.$children[2].list = this.categories[key]
      this.opensub = true
    },
    del(key,id) {
      if (confirm('Are you sure?')) {
        this.delLoader = true
        axios.delete(`/categories/${id}`)
        .then((response) => {
          this.delLoader = false
          this.categories.splice(key, 1)
          this.message='Category deleted'
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
      this.message = 'Category Added'
      this.color = 'black'
      this.snackbar = true
    },
    alertUp() {
      this.message = 'Category Added'
      this.color = 'black'
      this.snackbar = true
    },
    close() {
      this.openAdd = this.openEdit = this.opensub =false
    }
  },
  mounted() {
    this.loader=true
    axios.post('getcategories')
    .then((response) => {
      this.categories = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('getsubcategories')
    .then((response) => {
      this.subCategories = response.data
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