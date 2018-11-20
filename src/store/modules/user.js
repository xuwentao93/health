import { getToken, getUser, setUser, setToken } from '@/utils/localStorage'

const user = {
  state: {
    user: getUser(),
    token: getToken()
  },
  getters: {
    user: state => state.user,
    token: state => state.token
  },
  mutations: {
    setUser (state, user) {
      state.user = user
      setUser(user)
    },
    setToken (state, token) {
      state.token = token
      setToken(token)
    }
  }
}

export default user
