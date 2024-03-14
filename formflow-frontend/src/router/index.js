import { createRouter, createWebHistory } from 'vue-router'
import store from "@/store";
import HomeView from '../views/HomeView.vue'
import Login from '@/views/LoginView.vue'
import Register from '@/views/RegisterView.vue'
import Projects from '@/views/Projects/ProjectsView.vue'
import CreateProject from '@/views/Projects/CreateProject.vue'
import EditProject from '@/views/Projects/EditProject.vue'
import FormSubmissions from '@/views/Forms/FormSubmissions.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: {
      requireAuth: true,
      requireGuest: false,
    }
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      requireAuth: false,
      requireGuest: true,
    },
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      requireAuth: false,
      requireGuest: true,
    },
  },
  {
    path: '/logout',
    name: 'logout',
    component: function() {
      store.commit('logoutUser');
      router.push('/login');
    },
    meta: {
      requireAuth: true,
      requireGuest: false,
    }
  },
  {
    path: '/projects',
    name: 'projects',
    component: Projects,
    meta: {
      requireAuth: true,
      requireGuest: false,
    },
  },
  {
    path: '/projects/:id',
    name: 'Edit Project',
    component: EditProject,
    meta: {
      requireAuth: true,
      requireGuest: false,
    },
  },
  {
    path: '/projects/new',
    name: 'New Project',
    component: CreateProject,
    meta: {
      requireAuth: true,
      requireGuest: false,
    },
  },
  {
    path: '/forms/:id',
    name: 'Form Submissions',
    component: FormSubmissions,
    meta: {
      requireAuth: true,
      requireGuest: false,
    },
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requireAuth)) {
    if(store.getters.token == null) {
      next({ path: '/login' });
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.requireGuest)) {
    if (store.getters.token !== null) {
      next({ path: '/' });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router
