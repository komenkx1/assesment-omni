const state = {
  sidebar: typeof(window) !== 'undefined' ? localStorage.getItem('show-sidebar') ? (localStorage.getItem('show-sidebar') == 'true') : true : false,
    main: null,
};

const mutations = {
    ['SET_SIDEBAR'](state, data) {
		state.sidebar = data
		if (typeof(window) !== 'undefined') {
			localStorage.setItem('show-sidebar', data)
		}
	},
    ["SET_MAIN"](state, data) {
        state.main = data;
    },
};

const actions = {
 
};

const getters = {};

export default {
    state,
    mutations,
    actions,
    getters,
};
