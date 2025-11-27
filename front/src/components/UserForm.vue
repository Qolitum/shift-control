<script setup>
import { computed, ref } from 'vue';
import ModalComponent from '@/components/ModalComponent.vue';
import { vocation } from '@/consts/vocation.js';

const emit = defineEmits(['saveUser']);

const isOpen = ref(false);
const user = ref({ name: '', email: '', password: '' });

const title = computed(() => user.value.id ? 'Редактировать пользователя' : 'Создать пользователя');
const btnText = computed(() => user.value.id ? 'Сохранить' : 'Создать');

function open(currUser) {
  user.value = currUser;
  isOpen.value = true;
}

function save(currUser) {
  emit('saveUser', currUser);
  isOpen.value = false;
}

defineExpose({ open });
</script>

<template>
  <ModalComponent v-if="isOpen" @hideModal="isOpen = false">
    <div>
      <h2>{{ title }}</h2>
      <br>
      <v-text-field v-model="user.name" variant="outlined" label="Имя" />
      <v-select
        v-model="user.vocation"
        :items="vocation"
        item-value="value"
        item-title="name"
        variant="outlined"
        label="Должность"
      />
      <v-text-field v-model="user.email" variant="outlined" label="Email" />
      <v-text-field v-model="user.password" type="password" variant="outlined" label="Пароль" />
      <v-divider />
      <br>
      <div class="button-group">
        <v-btn color="blue" @click="save(user)">{{ btnText }}</v-btn>
      </div>
    </div>
  </ModalComponent>
</template>
