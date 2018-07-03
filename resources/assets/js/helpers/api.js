import config from '../config'

export const buildUrl = (endpoint) => {
  return config.api_url + endpoint
}