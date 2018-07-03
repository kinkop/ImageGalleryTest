import storeManager from 'store'

export const getAuthentication = () => {
  return storeManager.get('user')
}

export const storeAuthentication = (user) => {
  return storeManager.set('user', user)
}

export const unsetAuthentication = () => {
  return storeManager.remove('user')
}