const state = {
    user: [],
};

const mutations = {
    ["SET_USER"](state, data) {
        state.user = data;
    },
};

const actions = {
    fetchUsers({ getters }) {
        return axios.get("/api/user");
    },
    addUser({ getters }, data) {
        return axios.post("/api/user", data.dataForm);
    },
    updateUser({ getters }, data) {
        return axios.post(`/api/user/${data.id}`, data.dataForm);
    },
    deleteUser({ getters }, id) {
        return axios.delete(`/api/user/${id}`);
    },
};

const getters = {};

export default {
    state,
    mutations,
    actions,
    getters,
};
