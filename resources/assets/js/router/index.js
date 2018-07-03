import Vue from 'vue'
import store from '../store'
import VueRouter from 'vue-router'
import Home from '../pages/Home'
import Login from '../pages/Login'
import Gallery from '../pages/Gallery'

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
      },
    },
    {
      path: '/gallery',
      component: Gallery,
      name: 'gallery',
      meta: {
        title: 'Gallery',
        auth: true
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  let title = _.get(to, 'meta.title', 'Simple Image Gallery')
  document.title = title

  if (_.get(to, 'meta.auth') === true) {
    if (!store.state.user) {
      next({name: 'login'})
    } else {
      next()
    }

    return
  }
  next()

})


export default router