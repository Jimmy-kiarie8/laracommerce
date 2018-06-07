<template>
  <div>
    <v-app>
    <v-dialog v-model="imagedialog" persistent max-width="500px">
     <v-card>
      <v-card-title>
        <span class="headline">Add Product</span>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" @submit.prevent>
          <v-container grid-list-xl fluid>
            <v-layout wrap>
              <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">Upload</v-btn>
              <input type="file" @change="Getimage" accept="image/*" style="display: none" ref="fileInput" name="image">
              <img v-show="imagePlaced" :src="avatar" style="width: 200px; height: 200px;">
              <v-btn v-show="imagePlaced" class="primary" raised @click="cancle">Cancle</v-btn>
              <v-btn class="primary" raised @click.prevent="upload">Upload</v-btn>
            </v-layout>
          </v-container>
          <v-card-actions>
            <v-btn flat @click="resetForm">Close</v-btn>
            <v-spacer></v-spacer>
            <!-- <v-btn
            flat
            color="primary"
            @click="upload"
            >Add</v-btn> -->
          </v-card-actions>
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
  <div>
    <v-dialog v-model="Editdialog" max-width="1000px">
      <!-- <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn> -->
      <v-card>
        <v-card-title>
          <!-- <span class="headline">{{ formTitle }}</span> -->
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItem.title "
                :rules="rules.name"
                color="blue darken-2"
                label="Title"
                required
                ></v-text-field>
              </v-flex>
              <v-flex xs12 sm3>
                <v-text-field
                v-model="editedItem.list_price"
                color="blue darken-2"
                label="List Price"
                type="number"
                required
                ></v-text-field>
              </v-flex>
              <v-flex xs12 sm3>
                <v-text-field
                v-model="editedItem.price "
                color="blue darken-2"
                label="Price"
                type="number"
                required
                ></v-text-field>
              </v-flex>
              <select class="custom-select custom-select-sm col-md-3" v-model="editedItem.brand_id">
                <label for="">Brand</label>
                <option v-for="brand in brands" :value="brand.id">{{brand.brand_name}}</option>
              </select>
              <select class="custom-select custom-select-sm col-md-3" v-model="editedItem.category_id">
                <label for="">Parent Category</label>
                <option v-for="category in categories" :value="category.id">{{category.category}}</option>
              </select>
              <select class="custom-select custom-select-sm col-md-3" v-model="editedItem.sub_id">
                <label for="">Child Category</label>
                <option v-for="subcat in subcats" :value="subcat.id" v-if="editedItem.category_id === subcat.category_id">{{subcat.subcat_name}}</option>
              </select>
              <v-flex xs12>
                <v-text-field
                  v-model="editedItem.description"
                  color="teal"
                  multi-line
                >
                  <div slot="label">
                    Description <small>(optional)</small>
                  </div>
                </v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
          <v-btn color="blue darken-1" flat @click="updatePro">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-card>
      <v-flex sm10 offset-sm1>
        <v-card-title>
          Products
          <v-btn @click="openAddModal" flat>Add A Product</v-btn>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="search"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table 
          :loading="loading"         
          :headers="headers"
          :items="products"
          :search="search"
          class="elevation-1"
        >
        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
          <template slot="items" slot-scope="props">
            <td>{{ props.item.title }}</td>
            <td class="text-xs-right">{{ props.item.brand_id }}</td>
            <td class="text-xs-right">{{ props.item.category_id }}</td>
            <td class="text-xs-right">{{ props.item.sub_id }}</td>
            <td class="text-xs-right">{{ props.item.Featured }}</td>
            <td class="justify-center layout px-0">
              <!-- <v-btn icon class="mx-0" @click="editItem(props.item)"> -->
                <v-btn flat color="teal" @click="editItem(props.item)">edit</v-btn>
              <!-- </v-btn> -->
              <!-- <v-btn icon class="mx-0" @click="addImage(props.item)"> -->
                <v-btn flat color="teal" @click="addImage(props.item)">Image</v-btn>
              <!-- </v-btn> -->
              <!-- <v-btn icon class="mx-0" @click="deleteItem(props.item)"> -->
                <v-btn flat color="pink" @click="deleteItem(props.item)">delete</v-btn>
              <!-- </v-btn> -->
            </td>
          </template>
          <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
          </v-alert>
        </v-data-table>        
      </v-flex>
    </v-card>
  </div>
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
<AddProduct :openAddRequest="openAdd" @alertRequest="alert" @closeRequest="close" :products="products"></AddProduct>
<EditProduct :openEditRequest="openEdit" @UpdateRequest="alertUp" @closeRequest="close" :products="products"></EditProduct>
</div>
</template>

<script>
let AddProduct = require('./AddProduct.vue')
let EditProduct = require('./EditProduct.vue')
export default {
  components: {
    AddProduct, EditProduct
  },
  data() {
    return{
      products: [],
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
      brands: {},
      loading: false,
      categories: {},
      subcats: {},
      openAdd: false,
      openEdit: false,
      snackbar: false,
      delLoader: false,
      Editdialog: false,
      message: '',
      color: 'black',
      timeout: 5000,
      loader: false,
      imagePlaced: true,
      search: '',
      errors: {},
      avatar: '',
      image: null,
      imagedialog: false,
      editedItem: {
        title: '',
        brand_id: null,
        category_id: null,
        sub_id: null,
        featured: 0,
      },
      imageAdd: {},
      avatar: '',
      headers: [
        {
          text: 'Product Name',
          align: 'left',
          sortable: false,
          value: 'name'
        },
        { text: 'Brand', value: 'brand_id' },
        { text: 'Category', value: 'category' },
        { text: 'Sub-category', value: 'category' },
        { text: 'Featured', value: 'featured' },
        { text: 'Actions', value: 'name', sortable: false }
      ],
    }
  },
  methods: {
    resetForm () {
      this.form = Object.assign({}, this.defaultForm)
      this.$refs.form.reset()
      this.close()
    },
    // Image Upload
    onPickFile() {
      this.$refs.fileInput.click()
    },
    onFilePicked(event) {
      this.imagePlaced = true
      const files = event.target.files
      let filename = files[0].name
      if (filename.lastIndexOf('.') <= 0) {
        return alert('please upload a valid image')
      }
      const fileReader = new FileReader()
      fileReader.addEventListener('load', () => {
        this.avatar = fileReader.result
      })
      fileReader.readAsDataURL(files[0])
      this.image = files[0]
    },
    
    Getimage(e) {
      let image = e.target.files[0];
      // this.read(image);
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e => {
        this.avatar = e.target.result
      }
      // this.imagePlaced = true
      let form = new FormData();
      form.append('image', image);
      this.file = form
      console.log(e.target.files);
    },

    upload() {
      // console.log(this.image);
      console.log(this.$data.image);
      axios.post(`/prodImage/${this.imageAdd.id}`, this.$data.file)
      .then((response) => {
        console.log(response);
        this.imagePlaced = false;
        this.color = 'black';
        this.text = 'Profile image updated';
        this.snackbar = true;
        // this.close()
      })

    },
    cancle() {
      this.imageAdd.avatar = ''
      this.imagePlaced = false;
    },
    openAddModal() {
      this.openAdd = true
    },
    del(key,id) {
      if (confirm('Are you sure?')) {
        this.delLoader = true
        axios.delete(`/products/${id}`)
        .then((response) => {
          this.delLoader = false
          this.products.splice(key, 1)
          this.message='Product deleted'
          this.color='black'
          this.snackbar = true
        })
        .catch((error) => {
          this.errors = error.response.data.errors
          // this.loader=false
        })
      }
    },

      editItem (item) {
        this.editedIndex = this.products.indexOf(item)
        this.editedItem = Object.assign({}, item)
        let brands = this.brands
        let category = this.category
        this.Editdialog = true
      },

      addImage(item) {
        this.editedIndex = this.products.indexOf(item)
        this.imageAdd = Object.assign({}, item)
        this.imagedialog = true
      },

      deleteItem (item) {
        const index = this.products.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.products.splice(index, 1)
      },

      updatePro () {
        axios.patch(`/products/${this.editedItem.id}`, this.$data.editedItem)
          .then((response) => {
            console.log(response);
            Object.assign(this.products[this.editedIndex], this.editedItem)
            this.message = 'product details Updated'
            this.color = 'black'
            this.snackbar = true
            this.close()
          })
          .catch((error) => {
            this.errors = error.response.data.errors
            this.message = 'Something went wrong'
            this.color = 'red'
            this.snackbar = true
          })
      },
    alert() {
      this.message = 'Product Added'
      this.color = 'black'
      this.snackbar = true
    },
    alertUp() {
      this.message = 'Product Added'
      this.color = 'black'
      this.snackbar = true
    },
    close() {
      this.openAdd = this.openEdit = this.dialog = this.imagedialog = this.Editdialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
    }
  },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

  mounted() {
    this.loading=true
    axios.post('getcategories')
    .then((response) => {
      this.categories = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('getBrands')
    .then((response) => {
      this.brands = response.data
    })
    .catch((error) => {
        this.errors = error.response.data.errors
    })

    axios.post('getsubcategories')
    .then((response) => {
      this.subcats = response.data
    })
    .catch((error) => {
        this.errors = error.response.data.errors
    })

    axios.post('getproducts')
    .then((response) => {
      this.products = response.data
      this.loading=false
    })
    .catch((error) => {
      this.errors = error.response.data.errors
      // this.loader=false
      this.loading=false
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