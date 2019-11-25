<template>
  <v-data-table
    :headers="headers"
    :items="Etudiants"
    :search="search"
    sort-by="dessert"
    class="my-5 elevation-5"
    hide-default-footer
     style="border-radius:25px;"
  >
    <template v-slot:top>
      <v-toolbar   color="white" style="border-radius:20px;">
        <v-toolbar-title>Etudiants</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
        v-model="search"
        append-icon="mdi-account-search"
        label="Rechercher"
        single-line
        hide-details
      ></v-text-field>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" dark class="mb-133" v-on="on">Ajouter
               <v-icon right dark>mdi-account-plus</v-icon>
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.nom" label="Nom"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.prenom" label="Prénom"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.date_naissance" label="Date de naissance"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.adresse" label="Adresse"></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-3" text @click="close">Fermer</v-btn>
              <v-btn color="blue darken-3" text @click="Sauvegarder">Sauvegarder</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

    <v-dialog v-model="dialogg"  max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Information étudiant</span>
        </v-card-title>
        <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.nom" label="Nom" :disabled="true"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.prenom" label="Prénom" :disabled="true"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.email" label="Email" :disabled="true"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.date_naissance" label="Date de naissance" :disabled="true"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.adresse" label="Adresse" :disabled="true"></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialogg = false">Fermer</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  
      </v-toolbar>
    </template>
    <template v-slot:item.action="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-account-edit
      </v-icon>
      <v-icon
        small
        class="mr-2"
        @click="showitem(item)"
      >
        mdi-account-card-details
      </v-icon>
      <v-icon
        small
        class="mr-2"
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
      
    </template>
    
  </v-data-table>
</template>


<script>
  export default {
    data: () => ({
      dialog: false,
      dialogg: false,
      search: '',
      headers: [
        {
          text: 'Nom',
          align: 'left',
          sortable: true,
          value: 'nom',
        },
        { text: 'Prénom', value: 'prenom' },
        { text: 'Groupe', value: 'grp' },
        { text: 'Email', value: 'email' },
        { text: 'Date de naissance', value: 'date_naissance' },
        { text: 'Adresse', value: 'adresse' },
        { text: 'Matricule', value: 'adresse' },
        { text: 'Actions', value: 'action', sortable: false },
      ],
      Etudiants: [],
      editedIndex: -1,
      editedItem: {
        nom: '',
        prenom: '',
        email: '',
        date_naissance: '',
        adresse: '',
      },
      defaultItem: {
        nom: '',
        prenom: '',
        email: '',
        date_naissance: '',
        adresse: '',
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Ajouter étudiant' : 'Modifier étudiant'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },
    

    methods: {
      initialize () {
        axios.get('/liste').then(response => {
          this.Etudiants = response.data
        });
      },
      
      editItem (item) {
        this.editedIndex = this.Etudiants.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.Etudiants.indexOf(item)
        confirm('Voulez vous vraiment supprimer cet élément?') && this.Etudiants.splice(index, 1)
        console.log(item.matricule)
        /*axios.delete(item.matricule+'/delete').then(response => {
          console.log(response.date)
        });*/
      },

      showitem(item){
        this.editedIndex = this.Etudiants.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogg = true
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.Etudiants[this.editedIndex], this.editedItem)
        } else {
          this.Etudiants.push(this.editedItem)
        }
        this.close()
      },
    },
  }
</script>