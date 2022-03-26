<template>
  <v-card
    :loading="loading"
    class="mx-auto my-12"
    max-width="374"
  >
    <template slot="progress">
      <v-progress-linear
        color="deep-purple"
        height="10"
        indeterminate
      ></v-progress-linear>
    </template>

    <v-img
      height="250"
      src="https://10empresa.com/wp-content/uploads/2019/08/Definici%C3%B3n-del-producto-y-servicio.png"
    ></v-img>

    <v-card-title>{{name}}</v-card-title>

    <v-card-text>
      <v-row
        align="center"
        class="mx-0"
      >
        <div class="grey--text ms-4">
          Stock ({{stock}})
        </div>
      </v-row>

      <div class="my-4 text-subtitle-1">
        $ {{precio}}
      </div>

      <div>{{description}}</div>
    </v-card-text>
    <v-card-actions>
      <v-btn
        color="deep-purple lighten-2"
        text
      >
        Comprar
      </v-btn>
      <router-link to="/">
      <v-btn
        color="deep-purple lighten-2"
        text
      >
        Regresar
      </v-btn></router-link>
    </v-card-actions>
  </v-card>
</template>
<script>
  export default {
    data: () => ({
      loading: false,
      selection: 1,
      name: 'Prueba',
      description: 'Esta es una descripcion de prueba',
      precio: '120',
      stock: '12',
    }),
    mounted () {
        this.cargar()
    },
    methods: {
        async cargar () {
        // console.log(this.$route)
        const url = 'http://127.0.0.1:8000/productos' + this.$route.path
        await this.$axios.$get(url).then((response) => {
          console.log(response)
          console.log(url)
          if (response.length === 0) {
              // this.$router.push('/')
          } else {
              this.name = response[0].nombre
              this.description = response[0].descripcion
              this.precio = response[0].precio
              this.stock = response[0].stock
          }
        }).catch((error) => {
           if (this.$axios.isCancel(error)) {
             console.log('Request canceled', error) 
            } else {
              // handle error
            }
        })
        }
    }
    
  }
</script>
