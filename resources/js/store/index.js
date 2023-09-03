import { createStore } from 'vuex'

import main from './modules/main'
import auth from './modules/auth'
import user from './modules/user'

const state = {
  state: {},
  mutations: {},
  action: {},
  modules: {
    main,
    auth,
    user
  }
}

export default createStore(state)