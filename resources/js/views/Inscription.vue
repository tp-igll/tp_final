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
                :counter="10"
                required
                
  single-line
                type="number"
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
      <v-alert 
      border="top"
      colored-border
      type="error"
      elevation="5"
       v-model="alert">
      Veuillez remplir tous les champs!
    </v-alert>
      <v-alert 
      border="top"
      colored-border
      type="success"
      elevation="5"
       v-model="alertt">
      Inscription avec succès !
    </v-alert>
    
</div>

</template>
<style>
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}
input[type=number] {
    -moz-appearance:textfield; /* Firefox */
}
</style>
<script>
 import { validationMixin } from 'vuelidate'
  import { required, maxLength } from 'vuelidate/lib/validators'

  export default {
    mixins: [validationMixin],

    validations: {
      name: { required },
      prenom: { required },
      adresse:{required},
      telephone:{required, maxLength: maxLength(12)},
    },

    data: () => ({
      name: '',
      prenom:'',
      adresse:'',
      telephone:'',
      date: new Date().toISOString().substr(0, 10),
      alert:false,
      alertt:false,
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
        !this.$v.telephone.maxLength && errors.push('Le numéro de téléphone ne doit pas dépasser 10 chiffres.')
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

    },
    watch: {
      date () {
        this.dateFormatted = this.formatDate(this.date)
      },
    },

    methods: {
      submit () {
        this.$v.$touch()
        this.infos= {
          nom:this.name,
          prenom:this.prenom,
          num:this.telephone,
          adresse:this.adresse,
          date_naissance:this.dateFormatted
        }
        var _this=this;
        console.log(_this.infos)
        axios.post('/inscription', _this.infos).then(response => {
          _this.$router.push({name:''})
          console.log(response.data)
        })
        .catch(error=>console.log(error));
        if(this.name=='' || this.prenom=='' || this.adresse=='' || this.telephone=='' || this.dateFormatted==''){
          this.alert=true
          this.alertt=false
        }
        else{
          this.alert=false
          this.alertt=true
        }
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