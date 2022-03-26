<template>
 <v-card>
    <v-card-title>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-dialog
          v-model="dialog"
          max-width="500px"
        >
          <v-card>
            <v-card-title>
              <span class="text-h5">Editar</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Seguro que deseas eliminar?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
    <v-data-table
      :headers="headers"
      :search="search"
      :items="desserts"
    >
    <template v-slot:[`item.nombre`]="{ item }">
        <router-link :to="item.slug">
            {{item.nombre}}
        </router-link>
      </template>
    <template v-slot:[`item.id`]="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    </v-data-table>
  </v-card>
</template>

<script>
export default {
      data () {
      return {
        dialog: false,
        dialogDelete: false,     
        editedIndex:-1,
        editedItem: {},   
        search: '',
        headers: [
          {
            text: 'Nombre',
            align: 'start',
            filterable: true,
            value: 'nombre',
            rout:'/'
          },
          { text: 'Descripción', value: 'descripcion' },
          { text: 'Slug', value: 'slug' },
          { text: 'Precio', value: 'precio' },
          { text: 'Stock', value: 'stock' },
          { text: 'Action', value: 'id' }
        ],
        desserts: [            
        ],
      }
    },
    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },
    mounted () {
        this.cargar()
    },
    methods:{
        async cargar () {
        await this.$axios.$get('http://127.0.0.1:8000/productos').then((response) => {
          console.log(response)
          this.desserts = response
        }).catch((error) => {
           if (this.$axios.isCancel(error)) {
             console.log('Request canceled', error) 
            } else {
              // handle error
            }
        })
        },
        async eliminar (item) {
            await this.$axios.$delete('http://127.0.0.1:8000/productos/' + item.id).then((response) => {
          console.log(response)
        }).catch((error) => {
           if (this.$axios.isCancel(error)) {
             console.log('Request canceled', error) 
            } else {
              // handle error
            }
        })
        },
         editItem (item) {
            this.$emit('editItem',item)
            // this.editedIndex = this.desserts.indexOf(item)
            // this.editedItem = item
            // this.dialog = true
        },

        deleteItem (item) {
            this.editedIndex = this.desserts.indexOf(item)
            this.editedItem = item
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.desserts.splice(this.editedIndex, 1)
            this.eliminar(this.editedItem)
            this.closeDelete()
        },

        close () {
            this.dialog = false
            this.$nextTick(() => {
            this.editedItem = {}
            this.editedIndex = -1
            })
        },

        closeDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
            this.editedItem = {}
            this.editedIndex = -1
            })
        },
        save () {
        if (this.editedIndex > -1) {
          Object.assign(this.desserts[this.editedIndex], this.editedItem)
        } else {
          this.desserts.push(this.editedItem)
        }
        this.close()
      } 
    }
}
</script>

<style>

</style>
