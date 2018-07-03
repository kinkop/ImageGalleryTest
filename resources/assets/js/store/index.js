import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'
import { getAuthentication } from '../auth'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    user: getAuthentication()
  },
  actions,
  mutations
})

export default store