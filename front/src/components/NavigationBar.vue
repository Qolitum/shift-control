<script setup>
const routes = [
  { path: '/users', viewName: 'Пользователи', icon: 'mdi-account' },
  { path: '/shifts', viewName: 'Смены', icon: 'mdi-clock-time-eight' },
];
</script>

<template>
  <div class="navigation-bar">
    <h2>Shift-control</h2>
    <div class="links">
      <div
        v-for="(route, key) in routes"
        :key="key"
      >
        <router-link v-if="route.path" :to="route.path" active-class="active-link">
          <v-btn variant="text" class="link">
            <v-icon :icon="route.icon" style="margin-right: 5px"/>
            {{ route.viewName }}
          </v-btn>
        </router-link>
        <br v-else/>
      </div>
    </div>
  </div>
</template>

<style scoped>
.navigation-bar {
  position: fixed;
  overflow-x: hidden;
  display: flex;
  flex-direction: column;
  width: 240px;
  height: 100%;
  background-color: #2c3e50;
  color: white;
  text-align: left;
}
.navigation-bar h2 {
  display: inline-block;
  margin: 20px auto;
}
.links {
  display: inline-block;
  text-align: left;
}
.link {
  display: inline-block;
  text-decoration: none;
  color: white;
  width: 100%;
}
.link .v-btn__content {
  justify-content: left;
}
.active-link {
  display: inline-block;
  text-decoration: none;
  background-color: cornflowerblue;
  width: 100%;
}
</style>
