import config from '../config'
import endpoints from '../config/endpoints'
import { buildUrl } from '../helpers/api'

export const login = (email, password) => {
  return axios.post(buildUrl(endpoints.login), {
    email,
    password
  })
}

export const logout = () => {
  return axios.post(buildUrl(endpoints.logout))
}


export const getImageUploads = () => {
  return axios.get(buildUrl(endpoints.image_upload))
}

export const deleteImageUpload = (id) => {
  return axios.delete(buildUrl(`${endpoints.image_upload}/${id}`))
}