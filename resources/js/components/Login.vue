<template>
 <div id="app">
  <span class="bg"></span>
  <v-app id="inspire">
    <v-content>
      <v-container
        fluid
        fill-height
      >
        <v-layout
          align-center
          justify-center
        >
          <v-flex
            xs12
            sm8
            md4
          >
            <v-card class="elevation-12">
              <v-toolbar
                color="#004d00"
                dark
                flat
              >
                <v-toolbar-title>Connexion</v-toolbar-title>
                <v-spacer></v-spacer>
                
                  
                  
                
              </v-toolbar>
              <v-card-text>
                <v-form ref="form">
                  <v-text-field
                    label="Adresse email"
                    name="login"
                    prepend-icon="mail"
                    type="text"
                    v-model="login"
                    :rules="inputrules"
                  ></v-text-field>

                  <v-text-field
                    v-model="password"
                    label="Mot de passe"
                    name="password"
                    prepend-icon="lock"
                    type="password"
                    :rules="inputruless"
                  ></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions class="justify-center">
                
                <v-btn  color="green" v-on:click="submit">Connexion </v-btn>
                
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</div>
</template>

  <script>
    
  export default{ 
     data: () => ({
          login:'',
          password:'',
          inputrules:[
          v=> v.length >=3 || 'Veuillez introduire une adresse mail valide.'
          ],
          inputruless:[
          v=> v.length >=1 || 'Veuillez introduire un mot de passe valide.'
          ]
       }),
      methods:{
        submit(){
          if (this.$refs.form.validate()) {
            console.log(this.login, this.password),
            this.$router.push({ path: '/Liste' })
            
          }
        }
      }
 
}
  </script>


