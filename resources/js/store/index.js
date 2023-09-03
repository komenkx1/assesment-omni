import { createStore } from 'vuex'

import main from './modules/main'
import auth from './modules/auth'

const state = {
  state: {},
  mutations: {},
  action: {},
  modules: {
    main,
    auth
  }
}

export default createStore(state)