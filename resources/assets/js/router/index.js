import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../pages/Home'
import Login from '../pages/Login'
import store from '../store'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'hash',
  routes: [
    {
      path: '/',
      component: Home,
      name: 'root',
      meta: {
        title: 'Home',
        auth: true
      }
    },
    {
      path: '/login',
      component: Login,
      name: 'login',
      meta: {
        title: 'Login',
        auth: false
      }
    },
  ]
})

router.beforeEach((to, from, next) => {
  if (store.state.user) {
    next()
  } else {
    if (_.get(to, 'meta.auth') === true) {
      next({name: 'login'})
    } else {
      next()
    }

  }

})


export default router