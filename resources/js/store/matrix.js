import router from "@/router/router";
import types from "@/store/types";
import axios from "axios";

const state = {
    partners: null,
    partner: null
};

const getters = {
    [types.PARTNERS_GET_ITEMS]: state => {
        return state.partners;
    },
    [types.PARTNERS_GET_DETAIL]: state => {
        return state.partner;
    }
};

const mutations = {
    [types.PARTNERS_MUTATION_SAVE]: (state, payload) => {
        state.partners = payload;
    },
    [types.PARTNERS_MUTATION_DETAIL_SAVE]: (state, payload) => {
        state.partner = payload;
    }
};

const actions = {
    ['ADD']: async (
        { commit, dispatch, rootGetters },
        params = null
    ) => {
        commit(types.APP_MUTATION_TOGGLE_FETCHING);
        try {
            const response = await axios.get("/np_partner", {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization:
                        "Bearer " +
                        rootGetters[types.AUTH_GET_CREDENTIALS].tokens
                            .access_token
                },
                params
            });
            commit(types.PARTNERS_MUTATION_SAVE, response.data);

            return response.data;
        } catch (error) {
        }
    },
    
};

export default {
    getters,
    state,
    mutations,
    actions
};
