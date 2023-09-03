import { createStore } from 'vuex'

import main from './modules/main'
import auth from './modules/auth'
import user from './modules/user'
import log from './modules/log'

const state = {
  state: {},
  mutations: {},
  action: {},
  modules: {
    main,
    auth,
    user,
    log
  }
}

export default createStore(state)