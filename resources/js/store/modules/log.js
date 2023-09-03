const state = {
    log: [],
};

const mutations = {
    ["SET_LOG"](state, data) {
        state.log = data;
    },
};

const actions = {
    fetchLog({ getters }) {
        return axios.get("/api/get-log");
    },
};

const getters = {};

export default {
    state,
    mutations,
    actions,
    getters,
};
