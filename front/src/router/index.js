import { createRouter, createWebHistory } from 'vue-router';
import UsersListView from '@/views/UsersListView.vue';
import ShiftsListView from '@/views/ShiftsListView.vue';

export const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  linkActiveClass: 'active',
  routes: [
    { path: '/users', name: 'users', component: UsersListView },
    { path: '/shifts', name: 'shifts', component: ShiftsListView },
  ],
});

export default router;
