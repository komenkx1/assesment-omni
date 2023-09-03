const state = {
  user: {},
}

const mutations = {
	['SET_AUTH_USER'](state, data) {
		state.user = data
	},
 
}

const actions = {
  getUser ({ getters },id) {
    return axios.get('/api/get-auth-user/')
  },
  login ({ commit }, data) {
    commit('SET_AUTH_USER', data.data)
    localStorage.setItem('token', data.access_token)
  },
  signOut({ commit }) {
    return axios.post('/api/logout/')
  }

}

const getters = {
  isAuthenticated (state, getters) {
    return localStorage.getItem('token') !== null
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}