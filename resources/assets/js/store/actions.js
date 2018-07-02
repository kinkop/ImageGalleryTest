import * as api from '../api'
import * as types from './mutation_types'
import { storeAuthentication} from '../auth'

const login = ({state, commit}, payload) => {
  return new Promise((resolve, reject) => {
    api.login(payload.email, payload.password)
      .then((response) => {
        const user = _.get(response, 'data.data')
        commit(types.SET_USER, )

        resolve(response)
      })
      .catch((err) => {
        reject(err)
      })
  })
}

export default {
  login
}