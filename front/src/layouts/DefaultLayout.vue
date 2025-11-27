<script setup>
import NavigationBar from '@/components/NavigationBar.vue';
</script>

<template>
  <div class="default-layout">
    <NavigationBar/>
    <div class="slot">
      <slot/>
    </div>
  </div>
</template>

<style scoped>
.default-layout {
  display: flex;
  height: 100%;
}
.slot {
  margin-left: 240px;
  width: 100%;
  padding: 20px;
}
@media (max-width: 1000px) {
  .default-layout {
    font-size: 14px;
  }

  .slot {
    margin-left: 0;
  }
}
@media (max-width: 400px) {
  .default-layout {
    font-size: 12px;
  }

  .slot {
    padding: 10px;
  }
}
</style>
