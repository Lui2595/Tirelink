<template>
  <form>
    <v-text-field
      v-model="name"
      :error-messages="nameErrors"
      label="Nombre de producto"
      required
      @input="$v.name.$touch()"
      @blur="$v.name.$touch()"
    ></v-text-field>
    <v-text-field
      v-model="description"
      :error-messages="descriptionErrors"
      label="Descipción"
      required
      @input="$v.description.$touch()"
      @blur="$v.description.$touch()"
    ></v-text-field>
    <v-text-field
      v-model="slug"
      :error-messages="slugErrors"
      label="Slug"
      required
      @input="$v.slug.$touch()"
      @blur="$v.slug.$touch()"
    ></v-text-field>
    <v-text-field
      v-model="precio"
      :error-messages="precioErrors"
      label="Precio"
      required
      @input="$v.precio.$touch()"
      @blur="$v.precio.$touch()"
    ></v-text-field>
    <v-text-field
      v-model="stock"
      :error-messages="stockErrors"
      label="Precio"
      required
      @input="$v.stock.$touch()"
      @blur="$v.stock.$touch()"
    ></v-text-field>
    <v-btn
      class="mr-4"
      @click.prevent="submit"
    >
      submit
    </v-btn>
    <v-btn @click="clear">
      clear
    </v-btn>
  </form>
</template>
<script>
  import { validationMixin } from 'vuelidate'
  import { required, minLength , minValue, numeric } from 'vuelidate/lib/validators'

  export default {
    mixins: [validationMixin],
    validations: {
      name: { required, minLength: minLength(2) },
      description: { required, minLength: minLength(10) },
      slug:  { required, minLength: minLength(5)},
      precio:  { required, minValue: minValue(1), numeric},
      stock:  { required, minValue: minValue(1), numeric}
    },
    data: () => ({
      name: '',
      description: '',
      slug: '',
      precio: '',
      stock: '',
      updateId:-1
    }),
    computed: {
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.minLength && errors.push('Nombre debe de ser minimo de 2 caracteres')
        !this.$v.name.required && errors.push('Nombre es requerido')
        return errors
      },
      descriptionErrors () {
        const errors = []
        if (!this.$v.description.$dirty) return errors
        !this.$v.description.minLength && errors.push('Descripción debe de ser minimo de 10 caracteres')
        !this.$v.description.required && errors.push('Descripción es requerida')
        return errors
      },
      slugErrors () {
        const errors = []
        if (!this.$v.slug.$dirty) return errors
        !this.$v.slug.minLength && errors.push('Slug debe de ser minimo de 5 caracteres')
        !this.$v.slug.required && errors.push('Slug es requerido')
        return errors
      },
      precioErrors () {
        const errors = []
        if (!this.$v.precio.$dirty) return errors
        !this.$v.precio.numeric && errors.push('Precio debe de ser un numero')
        !this.$v.precio.minValue && errors.push('Precio debe de ser minimo de 1')
        !this.$v.precio.required && errors.push('Precio es requerido')
        return errors
      },
      stockErrors () {
        const errors = []
        if (!this.$v.stock.$dirty) return errors
        !this.$v.stock.numeric && errors.push('Stock debe de ser un numero')
        !this.$v.stock.minValue && errors.push('Stock debe de ser minimo de 1')
        !this.$v.stock.required && errors.push('Stock es requerido')
        return errors
      },
    },

    methods: {
      async submit () {
        this.$v.$touch()
        const obj = {nombre:this.name,
        descripcion:this.description,
        slug:this.slug,
        precio:this.precio,
        stock:this.stock}
        let url = 'http://127.0.0.1:8000/productos'
        if (this.updateId !== -1) {
          url = 'http://127.0.0.1:8000/productos/' + this.updateId
        }
        await this.$axios.$post(url, obj).then((response) => {
          console.log(response)
          this.clear()
        }).catch((error) => {
           if (this.$axios.isCancel(error)) {
             console.log('Request canceled', error) 
            } else {
              // handle error
            }
        })
      },
      clear () {
        this.$v.$reset()
        this.name = ''
        this.description = ''
        this.slug = ''
        this.precio = ''
        this.stock = ''
        this.updateId = -1
        this.$emit('clear')
      },
      update (item) {
        console.log(item)
        this.name = item.nombre
        this.description = item.descripcion
        this.slug = item.slug
        this.precio = item.precio
        this.stock = item.stock
        this.updateId = item.id
      }
    },
  }
</script>
