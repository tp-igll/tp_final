<template>
     <div>
    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
    >
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-3"
      >
        <v-app-bar-nav-icon @click.stop="drawer = !drawer" class="white--text"></v-app-bar-nav-icon>
        <span class="hidden-sm-and-down white--text">geSco</span>
      </v-toolbar-title>
      
      <v-spacer></v-spacer>
    </v-app-bar>

    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
      class="elevation-5"
    >
    

      <v-list shaped>
          <v-list-item class="primary">
        <v-list-item-avatar>
          <v-icon class="white--text" size="40">mdi-account-circle</v-icon>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title class="white--text">Nom de l'utilisateur</v-list-item-title>
        </v-list-item-content>
        
      </v-list-item>
   
      <v-list-item-group v-model="item" color="primary">
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          router :to="item.route"
        >
          <v-list-item-icon>
            <v-icon v-text="item.icon"></v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="item.text"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
    </v-navigation-drawer>
  </div>

</template>



<script>

export default {
    data(){
        return{
            drawer: false,
            items: [
                { icon: 'mdi-home', text: 'Acceuil', route:'/Acceuil'},
                { icon: 'mdi-account-plus', text: 'Inscrire étudiant', route:'/Inscription'},
                { icon: 'mdi-view-list', text: 'Liste des étudiants', route:'/Liste' },
                { icon: 'mdi-alert-circle', text: 'Les autres', route:'/' },]
        }
    }
}
</script>
