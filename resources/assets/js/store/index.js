import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'
import { getStoreAuthentication } from '../auth'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    user: null
  },
  actions,
  mutations
})

export default store