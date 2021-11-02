import Vue from 'vue'
import Router from 'vue-router'

// Containers
const TheContainer = () => import('@/containers/TheContainer')

// Views
const Dashboard = () => import('@/views/Dashboard')
const Users = () => import('@/views/users/Users')
const Categories = () => import('@/views/categories/Categories')
const Products = () => import('@/views/products/Products')


// Views - Pages
const Login = () => import('@/views/auth/Login')


Vue.use(Router)

export default new Router({
  mode: 'hash', // https://router.vuejs.org/api/#mode
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes()
})

function configRoutes () {
  return [
    {
      path: '/',
      redirect: '/dashboard',
      name: 'Tablero',
      component: TheContainer,
      children: [
        /**
         * Ruta principal del tablero
         */
        {
          path: 'dashboard',
          name: 'Tablero',
          component: Dashboard,
          meta: { auth: true },
        },
        /**
         * Gestión de usuarios
         */
        {
          path: 'users',
          name: 'Usuarios',
          component: Users,
          meta: { auth: true },
        },
        /**
         * Gestión de Categorías
         */
        {
          path: 'categories',
          name: 'Categorías',
          component: Categories,
          meta: { auth: true },
        },
        /**
         * Gestión de Productos
         */
        {
          path: 'products',
          name: 'Productos de música',
          component: Products,
          meta: { auth: true },
        },
      ]
    },
    {
      path: '/login',
      name: 'Login',
      component: Login,
      meta: { guest: true }
    }
  ]
}

