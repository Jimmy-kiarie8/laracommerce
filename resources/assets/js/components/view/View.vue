<template>
  <div>
    <v-app>
      <v-layout>
        <v-flex xs12 sm12>
          <v-card>
            <v-card-media src="/storage/background/tylor.jpeg" height="630px" width="100%">
             <h1 id="looks"><b>NEW <span style="color: #0fb7a4; line-height: 36px;">Looks</span></b></h1>
           </v-card-media>
         </v-card>
       </v-flex>
     </v-layout>
     <v-layout>
      <v-flex xs12 sm10 offset-sm1>
        <v-layout>
          <v-flex xs12 sm3 v-for="product, key in products" :key="product.id">
            <v-card>
              <v-card-media :src="product.image" height="200px"></v-card-media>
              <v-card-title primary-title>
                <div>
                  <p class="text-danger">List Price:<s>{{product.list_price}}</s></p>
                  <p>Our Price:{{product.price}}</p>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="orange" @click="openDetailModal(key)">Details</v-btn>
                <!-- <v-btn flat color="orange">Explore</v-btn> -->
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </v-app>
  <Details :openDetail="details" @closeRequest="close"></Details>
</div>
</template>

<script>
let Details = require('./Details.vue')
export default {
  components: {
    Details
  },
  data() {
    return{
      products: [],
      loading: false,
      details: false,
    }
  },
  methods: {
    openDetailModal(key) {
      console.log(this.products[key]);
      this.$children[0].list = this.products[key]
      this.details = true
    },
    close() {
      this.details = false
    }
  },
  mounted() {
    this.loading=true

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