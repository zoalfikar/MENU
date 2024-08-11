import { createStore } from 'vuex'
import axios from "axios";

export default createStore({

    state: {
        menu: [],
        users: [],
        validationErorrs: [],
        user: null,
        responsFromServer: {
            message: null,
            code: null
        },
    },
    actions: {
        getRestaurantMenu({ commit }) {
            axios.get(`/menu/get`)
                .then((response) => {
                    commit("setMenu", response.data.menu)
                })
        },
        getUsers({ commit }) {
            axios.get(`/users`)
                .then((response) => {
                    commit("setUsers", response.data.users)
                })
        },
        createUser({ commit }, user) {
            axios.post(`/users`, user)
                .then((response) => {
                    commit("addUser", { message: response.data.message, user: response.data.user })
                }).catch(error => {
                    if (error.response.status === 422) {
                        commit('setValidationErorrs', error.response.data.errors);
                    }
                })
        },
        deleteUser({ commit }, id) {
            axios.delete(`/users/${id}`)
                .then((response) => {
                    commit("deleteUser", { message: response.data.message, id: id })
                })
        },
        getMenu({ commit }) {
            axios.get(`/categories`)
                .then((response) => {
                    commit("setMenu", response.data.menu)
                })
        },
        createCategory({ commit }, category) {
            axios.post(`/categories`, category)
                .then((response) => {
                    commit("setResponseFromServer", { message: response.data.message })
                    this.dispatch('getMenu')
                }).catch(error => {
                    if (error.response.status === 422) {
                        commit('setValidationErorrs', error.response.data.errors);
                    }
                })
        },
        updateCategory({ commit }, data) {
            axios.put(`/categories/${data.id}`, data.category)
                .then((response) => {
                    commit("setResponseFromServer", { message: response.data.message })
                    this.dispatch('getMenu')
                }).catch(error => {
                    if (error.response.status === 422) {
                        commit('setValidationErorrs', error.response.data.errors);
                    }
                })
        },
        deleteCategory({ commit }, id) {
            axios.delete(`/categories/${id}`)
                .then((response) => {
                    commit("setResponseFromServer", { message: response.data.message })
                    this.dispatch('getMenu')
                })
        },
        createItem({ commit }, item) {
            axios.post(`/items`, item)
                .then((response) => {
                    commit("setResponseFromServer", { message: response.data.message })
                    this.dispatch('getMenu')
                }).catch(error => {
                    if (error.response.status === 422) {
                        commit('setValidationErorrs', error.response.data.errors);
                    }
                })
        },
        updateItem({ commit }, data) {
            axios.put(`/items/${data.id}`, data.item)
                .then((response) => {
                    commit("setResponseFromServer", { message: response.data.message })
                    this.dispatch('getMenu')
                }).catch(error => {
                    if (error.response.status === 422) {
                        commit('setValidationErorrs', error.response.data.errors);
                    }
                })
        },
        deleteItem({ commit }, id) {
            axios.delete(`/items/${id}`)
                .then((response) => {
                    commit("setResponseFromServer", { message: response.data.message })
                    this.dispatch('getMenu')
                })
        },
        setMenuDiscount({ commit }, discountPercent) {
            axios.post(`/categories/discount/all`, discountPercent)
                .then((response) => {
                    commit("setResponseFromServer", { message: response.data.message })
                    this.dispatch('getMenu')
                }).catch(error => {
                    if (error.response.status === 422) {
                        commit('setValidationErorrs', error.response.data.errors);
                    }
                })
        },
        getUser({ commit }) {
            axios.get(`/user`)
                .then((response) => {
                    commit("setUser", response.data.user)
                })
        },
        logout() {
            axios.get(`/logout`)
                .then((response) => {
                    location.reload()
                })
        },
    },
    mutations: {
        setUsers: (state, users) => {
            state.users = users;
        },

        addUser: (state, data) => {
            state.responsFromServer = data;
            state.users.push(data.user)
        },
        deleteUser: (state, data) => {
            state.responsFromServer = data;
            state.users = state.users.filter((u) => {
                return u.id !== data.id
            });
        },
        setMenu: (state, menu) => {
            state.menu = menu;
        },
        setResponseFromServer: (state, data) => {
            state.responsFromServer = data;
        },
        setValidationErorrs: (state, errors) => {
            state.validationErorrs = errors;
        },
        setUser: (state, user) => {
            state.user = user;
        },
    },
    getters: {

    }
})