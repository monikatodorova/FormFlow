import { createStore } from 'vuex'

export default createStore({
  state: {
    user: {
      token: localStorage.getItem("token"),
      name: null,
      email: null,
      avatar: {
        credentials: null,
        color: null,
        text: null,
      },
      loaded: false,
    },
    projects: {
      items: [],
      loaded: false,
    },
    currentProject: {
      hashId: null,
      name: null,
      loaded: false,
    },
    dropdown: null,
    forms: {
      items: [],
      loaded: false,
    }
  },
  getters: {
    user(state) {
      return state.user;
    },
    token(state) {
      return state.user.token;
    },
    projects(state) {
      return state.projects;
    },
    currentProject(state) {
      return state.currentProject;
    },
    dropdown(state) {
      return state.dropdown;
    },
    forms(state) {
      return state.forms;
    }
  },
  mutations: {
    updateUser(state, userPayload) {
      state.user.name = userPayload.name;
      state.user.email = userPayload.email;
      state.user.avatar = userPayload.avatar;
      state.user.loaded = true;
    },
    updateUserToken(state, token) {
      state.user.token = token;
      localStorage.setItem("token", token);
    },
    logoutUser(state) {
      localStorage.removeItem("token");
      state.user.token = null;
      state.user.name = null;
      state.user.email = null;
      state.user.avatar = null;
      state.projects.loaded = false;
    },
    updateProjects(state, projectsPayload) {
      state.projects.items = projectsPayload;
      state.projects.loaded = true;
    },
    updateCurrentProject(state, project) {
      state.currentProject.hashId = project.hashId;
      state.currentProject.name = project.name;
      state.currentProject.loaded = true;
    },
    clearDropdown(state) {
      state.dropdown = null;
    },
    saveDropdown(state, dropdown) {
      if(state.dropdown !== null) {
        state.dropdown.hideDropdown();
      }
      state.dropdown = dropdown;
    },
    updateForms(state, formsPayload) {
      state.forms.items = formsPayload;
      state.forms.loaded = true;
    },

  },
  actions: {
  },
  modules: {
  }
})
