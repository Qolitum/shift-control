<script setup>
import { ref, inject, computed } from 'vue';
import { toast } from 'vue3-toastify';
import { formatLocalDateTime } from '@/utils/format.js';

const axios = inject('axios');
const users = ref([]);
const userId = ref(0);
const page = ref(1);
const totalPages = ref(1);
const shifts = ref([]);

function getUsers() {
  axios.get('/api/users-with-shift-status').then((response) => {
    users.value = [{ id: 0, name: 'Все' }, ...response.data.users];
  });
  getShifts();
}

getUsers();

const hasActiveShift = computed(() => {
  return userId.value === 0 || users.value.find((x) => x.id === userId.value)?.has_active_shift;
});

const canStopShift = computed(() => {
  return userId.value !== 0 && users.value.find((x) => x.id === userId.value)?.has_active_shift;
});

function getShifts() {
  axios.get(`/api/shifts`, {
    params: {
      id: userId.value,
      page: page.value,
    },
  }).then((response) => {
    shifts.value = response.data.shifts;
    totalPages.value = response.data.totalPages;
  });
}

function openShift() {
  axios.post(`/api/shifts/open/${userId.value}`).then((response) => {
    toast.success(response.data.title);
    getUsers();
  });
}

function stopShift() {
  axios.post(`/api/shifts/stop/${userId.value}`).then((response) => {
    toast.success(response.data.title);
    getUsers();
  });
}
</script>

<template>
  <div>
    <h1>Смены</h1>
    <br />
    <v-data-table
      items-per-page="-1"
      hide-default-footer
      items-per-page-text="На странице"
      no-data-text="Ничего не найдено"
      :items="shifts"
    >
      <template v-slot:top>
        <v-toolbar rounded class="toolbar">
          <v-select
            v-model="userId"
            :items="users"
            item-value="id"
            item-title="name"
            variant="outlined"
            density="compact"
            label="Сотрудник"
            hide-details
            style="max-width: 250px !important; margin-left: 10px; margin-right: 10px;"
            @update:model-value="getShifts"
          />
          <v-btn
            variant="outlined"
            :disabled="hasActiveShift"
            @click="openShift"
            style="margin-right: 10px;"
          >
            Открыть смену
          </v-btn>
          <v-btn
            variant="outlined"
            :disabled="!canStopShift"
            @click="stopShift"
          >
            Оcтановить смену
          </v-btn>
        </v-toolbar>
      </template>
      <template v-slot:headers>
        <tr>
          <th>Имя</th>
          <th>Должность</th>
          <th>Время начала</th>
          <th>Время конца</th>
        </tr>
      </template>
      <template v-slot:item="{ item }">
        <tr>
          <td>{{ item.user.name }}</td>
          <td>{{ item.user.vocation }}</td>
          <td>{{ formatLocalDateTime(item.time_start) }}</td>
          <td>{{ formatLocalDateTime(item.time_end) }}</td>
        </tr>
      </template>
    </v-data-table>
    <v-pagination v-model="page" :length="totalPages" @update:modelValue="getShifts" />
  </div>
</template>

