<script setup>
import { ref, inject } from 'vue';
import UserForm from '@/components/UserForm.vue';
import { toast } from 'vue3-toastify';

const axios = inject('axios');
const users = ref([]);
const userForm = ref(null);

function getUsers() {
  axios.get('/api/users').then((response) => {
    users.value = response.data.users;
  });
}

getUsers();

function openUserForm(user = null) {
  if (!user) {
    user = {
      name: null,
      vocation: null,
      email: null,
      password: null,
    };
  }
  userForm.value.open(user);
}

async function getUserById(id) {
  try {
    const response = await axios.get(`/api/users/${id}`);
    openUserForm(response.data.user);
  } catch (error) {
    console.error('Ошибка при получении пользователя', error);
  }
}

async function createUser(user) {
  await axios.post('/api/users', {
    name: user.name,
    vocation: user.vocation,
    email: user.email,
    password: user.password,
  }).then((response) => {
    if (response.status === 200) {
      toast.success(response.data.title);
      getUsers();
    }
  }).catch(({ response }) => {
    if (response.status === 400) {
      toast.error(response.data.title);
    }
  });
}

async function updateUser(user) {
  await axios.put(`/api/users/${user.id}`, {
    name: user.name,
    vocation: user.vocation,
    email: user.email,
    password: user.password,
  }).then((response) => {
    if (response.status === 200) {
      toast.success(response.data.title);
    }
    getUsers();
  }).catch(({ response }) => {
    if (response.status === 400) {
      toast.error(response.data.title);
    }
  });
}

function saveUser(user) {
  if (user.id) {
    updateUser(user);
  } else {
    createUser(user);
  }
}

async function deleteUser(id) {
  await axios.delete(`/api/users/${id}`);
  getUsers();
}
</script>

<template>
  <div>
    <h1>Пользватели</h1>
    <br />
    <v-data-table
      items-per-page="-1"
      hide-default-footer
      items-per-page-text="На странице"
      no-data-text="Ничего не найдено"
      :items="users"
    >
      <template v-slot:top>
        <v-toolbar rounded>
          <v-btn variant="tonal" @click="openUserForm(null)">
            Добавить пользователя
          </v-btn>
        </v-toolbar>
      </template>
      <template v-slot:headers>
        <tr>
          <th>Имя</th>
          <th>Должность</th>
          <th>Email</th>
          <th></th>
        </tr>
      </template>
      <template v-slot:item="{ item }">
        <tr>
          <td>{{ item.name }}</td>
          <td>{{ item.vocation }}</td>
          <td>{{ item.email }}</td>
          <td>
            <v-btn variant="text" @click="getUserById(item.id)">
              <v-icon icon="mdi-pencil" />
            </v-btn>
            <v-btn variant="text" style="color: red" @click="deleteUser(item.id)">
              <v-icon icon="mdi-delete" />
            </v-btn>
          </td>
        </tr>
      </template>
    </v-data-table>
    <UserForm
      ref="userForm"
      @saveUser="saveUser"
    />
  </div>
</template>
