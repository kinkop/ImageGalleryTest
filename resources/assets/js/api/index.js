import config from '../config'

export const login = (email, password) => {
  console.log(email, password)
  return axios.post(config.api_url + config.endpoints.login, {
    email,
    password
  })
}