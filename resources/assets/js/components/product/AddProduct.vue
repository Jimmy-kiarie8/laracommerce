<template>
  <v-layout>
    <v-dialog v-model="sizeModal" persistent max-width="1000px">
     <v-card>
      <v-card-title>
        <span class="headline">Quantity&size</span>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" @submit.prevent="submit">
          <v-container grid-list-xl fluid>
            <v-layout wrap row v-for="i, index in 10" :key="`6${i}`">
                <v-flex xs6 sm8>
                  <v-text-field
                  v-model="form.size[index]"
                  :rules="rules.name"
                  color="blue darken-2"
                  label="Sizes"
                  required
                  ></v-text-field>
                </v-flex>
                <v-flex xs5 sm3 offset-sm1>
                  <v-text-field
                  v-model="form.quantity[index] "
                  :rules="rules.name"
                  color="blue darken-2"
                  label="Quantity"
                  type="number"
                  required
                  ></v-text-field>
                </v-flex>
            </v-layout>
          </v-container>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
            raised
            color="primary"
            @click="sizeModalclose"
            >Done</v-btn>
          </v-card-actions>
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>

  <v-dialog v-model="openAddRequest" persistent max-width="1000px">
   <v-card>
    <v-card-title>
      <span class="headline">Add Product</span>
      <v-btn flat @click="sizeModal = true">Quantity$Size</v-btn>
    </v-card-title>
    <v-card-text>
      <v-form ref="form" @submit.prevent="submit">
        <v-container grid-list-xl fluid>
          <v-layout wrap>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="form.title "
              :rules="rules.name"
              color="blue darken-2"
              label="Title"
              required
              ></v-text-field>
            </v-flex>
            <v-flex xs12 sm3>
              <v-text-field
              v-model="form.list_price "
              :rules="rules.name"
              color="blue darken-2"
              label="List Price"
              type="number"
              required
              ></v-text-field>
            </v-flex>
            <v-flex xs12 sm3>
              <v-text-field
              v-model="form.price "
              :rules="rules.name"
              color="blue darken-2"
              label="Price"
              type="number"
              required
              ></v-text-field>
            </v-flex>
            <select class="custom-select custom-select-sm col-md-3" v-model="form.brand_id">
              <label for="">Brand</label>
              <option v-for="brand in brands" :value="brand.id">{{brand.brand_name}}</option>
            </select>
            <select class="custom-select custom-select-sm col-md-3" v-model="form.category_id">
              <label for="">Parent Category</label>
              <option v-for="category in categories" :value="category.id">{{category.category}}</option>
            </select>
            <select class="custom-select custom-select-sm col-md-3" v-model="form.sub_id">
              <label for="">Child Category</label>
              <option v-for="subcat in subcats" :value="subcat.id" v-if="form.category_id === subcat.parent">{{subcat.category}}</option>
            </select>
            <v-flex xs12>
              <v-text-field
              v-model="form.description"
              color="teal"
              multi-line
              >
              <div slot="label">
                Bio <small>(optional)</small>
              </div>
            </v-text-field>
          </v-flex>
        </v-layout>
      </v-container>
      <v-card-actions>
        <v-btn flat @click="resetForm">Close</v-btn>
        <v-spacer></v-spacer>
        <v-btn
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
  props: ['openAddRequest', 'products'],
  data() {
    const defaultForm = Object.freeze({
      brand_id: '',
      sub_id: '',
      category_id: '',
      list_price: '',
      price: '',
      description: '',
      size: [],
      quantity: [],
      quantity_size: [],
    })
    return{
      sizeModal: false,
      form: Object.assign({}, defaultForm),
      errors: {},
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
      categories: {},
      subcats: {},
      brands: {},
      avatar: '',
      imagePlaced: false,
    }
  },

  computed: {
  qsize () {
      this.quantity_size =  this.quantity[index] + ':' + this.size[index]
      return this.quantity_size
    },
    formIsValid () {
      return (
        this.form.brand_id &&
        this.form.category_id &&
        this.form.sub_id &&
        this.form.list_price &&
        this.form.price
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
      axios.post('/products', this.$data.form)
      .then((response) => {
        console.log(response);
        this.$emit('alertRequest')
        this.$parent.products.push(response.data)  
        this.resetForm()
        this.close()
      })
      .catch((error) => {
        this.errors = error.response.data.errors
      })
    },
    sizeModalclose() {
      this.sizeModal = false
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


    axios.post('getsubcat')
    .then((response) => {
      this.subcats = response.data
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
  }
}
</script>
