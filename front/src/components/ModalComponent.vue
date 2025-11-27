<script setup>
const emit = defineEmits(['hideModal']);

/**
 * Скрыть модальное окно.
 */
function hideModal() {
  return emit('hideModal');
}
</script>

<template>
  <v-dialog
    :model-value="true"
    @click:outside="hideModal"
    @keydown.esc="hideModal"
    max-width="1200px"
    persistent
    scrollable
    content-class="elevation-0"
  >
    <v-card>
      <v-card-actions class="justify-end pa-2">
        <v-btn
          icon="mdi-close"
          variant="text"
          @click="hideModal"
          density="comfortable"
          aria-label="Закрыть модальное окно"
        ></v-btn>
      </v-card-actions>
      <v-card-text class="pa-4">
        <slot />
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<style scoped>
</style>