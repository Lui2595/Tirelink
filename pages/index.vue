<template>
  <div>
    <v-card>
      <v-card-title>
        Tabla de productos
      </v-card-title>
       <v-card-text>
          <Table  v-on:editItem="objectEdit" ref="table" />
        </v-card-text>
      </v-card>
      <v-card>
      <v-card-title ref="div1">
        Formulario
      </v-card-title>
      <v-card-text>
       <Form v-on:clear="clear" ref="form"/>
      </v-card-text>
      </v-card>
    </div>
</template>

<script>
import Table from '../components/Table.vue'
import Form from '../components/FormComp.vue'

export default {
  name: 'IndexPage',
  components: {
    Table,
    Form
  },
  methods:{
    objectEdit (item) {
      this.$refs.form.update(item)
      const element = this.$refs.div1
      const top = element.offsetTop
      window.scrollTo(0, top)
    },
    clear () {
      this.$refs.table.cargar()
    }
  }
}
</script>
