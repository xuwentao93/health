import Vue from 'vue'
import Vuex from 'vuex'
import user from './modules/user'
import email from './modules/email'
import bg from './modules/bg'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    user,
    email,
    bg
  }
})
