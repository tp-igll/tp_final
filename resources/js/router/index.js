import Vue from 'vue'
import VueRouter from 'vue-router'
import Acceuil from '../views/Acceuil.vue'
import Inscription from '../views/Inscription.vue'
import Liste from '../views/Liste.vue'

Vue.use(VueRouter)

const routes = [
  {
    
    path: '/Acceuil',
    name: 'Acceuil',
    component: Acceuil
  },
  {
    path: '/Liste',
    name: 'Liste',
    component: Liste
  },
  {
    path: '/Inscription',
    name: 'Inscription',
    component: Inscription
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
