<template>
<div class="Inscription">
   <v-card class="elevation-5 my-5" style="border-radius:20px;">
     <v-form>
        <v-card-title class="blue darken-3 elevation-5" style="color: white;font-family: sans-serif;border-radius:20px;">
          Inscrire étudiant
        </v-card-title>
        <v-container grid-list-sm >
          <v-layout
            row
            wrap
          >
            <v-flex xs6>
              <v-text-field
                v-model="name"
                :error-messages="nameErrors"
                required
                @input="$v.name.$touch()"
                @blur="$v.name.$touch()"
                placeholder="Nom"
                prepend-icon="mdi-account"
              ></v-text-field>
            </v-flex>
            <v-flex xs6>
              <v-text-field
                v-model="prenom"
                :error-messages="prenomErrors"
                
                
                required
                @input="$v.prenom.$touch()"
                @blur="$v.prenom.$touch()"
                placeholder="Prénom"
              ></v-text-field>
            </v-flex>

            <v-flex xs12>
              <v-text-field
               v-model="email"
                :error-messages="emailErrors"
                required
                @input="$v.email.$touch()"
                @blur="$v.email.$touch()"
                prepend-icon="mdi-email"
                placeholder="Email"
              ></v-text-field>
            </v-flex>
            
             <v-flex xs12>
  
        <v-menu
          ref="menu1"
          v-model="menu1"
          :close-on-content-click="false"
          transition="scale-transition"
          offset-y
          full-width
          max-width="290px"
          min-width="290px"
        >
          <template v-slot:activator="{ on }">
            <v-text-field
              v-model="dateFormatted"
              label="Date de naissance"
              persistent-hint
              prepend-icon="mdi-calendar-range"
              @blur="date = parseDate(dateFormatted)"
              v-on="on"
     

                
                required
            ></v-text-field>
          </template>
          <v-date-picker v-model="date" no-title @input="menu1 = false"></v-date-picker>
        </v-menu>
      </v-flex>
            <v-flex xs12>
              <v-text-field
              v-model="adresse"
                prepend-icon="mdi-home"
                placeholder="Adresse"
                :error-messages="adresseErrors"
                required
                @input="$v.adresse.$touch()"
                @blur="$v.adresse.$touch()"

              ></v-text-field>
            </v-flex>
            <v-flex xs12>
              <v-text-field
                v-model="telephone"
                prepend-icon="mdi-phone"
                placeholder="Téléphone"
                :error-messages="telephoneErrors"
                :counter="12"
                required
                @input="$v.telephone.$touch()"
                @blur="$v.telephone.$touch()"
              ></v-text-field>
            </v-flex>

          </v-layout>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
            <v-btn class="ma-2" color="primary" dark @click="submit">Inscrire
        <v-icon dark right>mdi-checkbox-marked-circle</v-icon>
            </v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
</div>

</template>

<script>
 import { validationMixin } from 'vuelidate'
  import { required, maxLength, email } from 'vuelidate/lib/validators'

  export default {
    mixins: [validationMixin],

    validations: {
      name: { required },
      prenom: { required },
      email: { required, email },
      adresse:{required},
      telephone:{required, maxLength: maxLength(12)},
    },

    data: vm => ({
      name: '',
      email: '',
      prenom:'',
      adresse:'',
      telephone:'',
      date: new Date().toISOString().substr(0, 10),
      dateFormatted: vm.formatDate(new Date().toISOString().substr(0, 10)),
      menu1: false,
    }),



    computed: {
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.required && errors.push('Le champ nom est obligatoire.')
        return errors
      },
      telephoneErrors () {
        const errors = []
        if (!this.$v.telephone.$dirty) return errors
        !this.$v.telephone.maxLength && errors.push('Le numéro de téléphone ne doit pas dépasser 12 caracteres.')
        !this.$v.telephone.required && errors.push('Le champ téléphone est obligatoire.')
        return errors
      },
      adresseErrors () {
        const errors = []
        if (!this.$v.adresse.$dirty) return errors
        !this.$v.adresse.required && errors.push('Le champ adresse est obligatoire.')
        return errors
      },
      computedDateFormatted () {
        return this.formatDate(this.date)
      },
      prenomErrors () {
        const errors = []
        if (!this.$v.prenom.$dirty) return errors
        !this.$v.prenom.required && errors.push('Le champ prénom est obligatoire.')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Veuillez introduire une adresse e-mail valide.')
        !this.$v.email.required && errors.push('Le champ e-mail est obligatoire.')
        return errors
      },

    },
    watch: {
      date () {
        this.dateFormatted = this.formatDate(this.date)
      },
    },

    methods: {
      submit () {
        console.log(this.$v);
        axios.post('/inscription', this.vm).then(response => {
          this.vm=({name: '' })
          console.log(response.data)
        })
        .catch(error=>console.log(error));
        
      },
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${day}/${month}/${year}`
      },
      parseDate (date) {
        if (!date) return null

        const [day, month, year] = date.split('/')
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      },
    },
  }
</script>