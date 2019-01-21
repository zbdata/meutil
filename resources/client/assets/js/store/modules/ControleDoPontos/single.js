function initialState() {
    return {
        item: {
            id: null,
            data: null,
            falta: false,
            feriado: false,
            matricula: null,
        },
        usersAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    usersAll: state => state.usersAll,
    
}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            params.set('falta', state.item.falta ? 1 : 0)
            params.set('feriado', state.item.feriado ? 1 : 0)
            if (_.isEmpty(state.item.matricula)) {
                params.set('matricula_id', '')
            } else {
                params.set('matricula_id', state.item.matricula.id)
            }

            axios.post('/api/v1/controle-do-pontos', params)
                .then(response => {
                    commit('resetState')
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors  = error.response.data.errors

                    dispatch(
                        'Alert/setAlert',
                        { message: message, errors: errors, color: 'danger' },
                        { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })
    },
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set('_method', 'PUT')

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            params.set('falta', state.item.falta ? 1 : 0)
            params.set('feriado', state.item.feriado ? 1 : 0)
            if (_.isEmpty(state.item.matricula)) {
                params.set('matricula_id', '')
            } else {
                params.set('matricula_id', state.item.matricula.id)
            }

            axios.post('/api/v1/controle-do-pontos/' + state.item.id, params)
                .then(response => {
                    commit('setItem', response.data.data)
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors  = error.response.data.errors

                    dispatch(
                        'Alert/setAlert',
                        { message: message, errors: errors, color: 'danger' },
                        { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })
    },
    fetchData({ commit, dispatch }, id) {
        axios.get('/api/v1/controle-do-pontos/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchUsersAll')
    },
    fetchUsersAll({ commit }) {
        axios.get('/api/v1/users')
            .then(response => {
                commit('setUsersAll', response.data.data)
            })
    },
    setData({ commit }, value) {
        commit('setData', value)
    },
    setFalta({ commit }, value) {
        commit('setFalta', value)
    },
    setFeriado({ commit }, value) {
        commit('setFeriado', value)
    },
    setMatricula({ commit }, value) {
        commit('setMatricula', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setData(state, value) {
        state.item.data = value
    },
    setFalta(state, value) {
        state.item.falta = value
    },
    setFeriado(state, value) {
        state.item.feriado = value
    },
    setMatricula(state, value) {
        state.item.matricula = value
    },
    setUsersAll(state, value) {
        state.usersAll = value
    },
    
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
