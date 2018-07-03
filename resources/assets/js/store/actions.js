import * as api from '../api'
import * as types from './mutation_types'
import { storeAuthentication, unsetAuthentication } from '../auth'

const login = ({state, commit}, payload) => {
  return new Promise((resolve, reject) => {
    api.login(payload.email, payload.password)
      .then((response) => {
        const user = _.get(response, 'data.data')
        commit(types.SET_USER, user)
        storeAuthentication(user)

        resolve(response)
      })
      .catch((err) => {
        reject(err)
      })
  })
}

const logout = ({state, commit}) => {
  return new Promise((resolve, reject) => {
    api.logout()
      .then((response) => {
        commit(types.SET_USER, null)
        unsetAuthentication()
        resolve(response)
      })
      .catch((err) => {
        reject(err)
      })
  })
}

export const getImageUploads = ({state, commit}) => {
  return api.getImageUploads()
}

export const deleteImageUpload = ({state, commit}, id) => {
 return api.deleteImageUpload(id)
}

export default {
  login,
  logout,
  getImageUploads,
  deleteImageUpload
}