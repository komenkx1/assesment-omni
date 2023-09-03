const state = {
  user: {},
}

const mutations = {
	['SET_USER'](state, data) {
		state.user = data
	},
 
}

const actions = {
  getUser ({ getters },id) {
    return axios.get('/api/user/'+id)
  },
  login ({ commit }, data) {
    localStorage.setItem('token', data.access_token)
    commit('SET_USER', data.user)
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