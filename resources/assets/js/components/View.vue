<template>
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
</v-app>
</template>

<script>
export default {
   mounted() {
      console.log('Component mounted.')
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