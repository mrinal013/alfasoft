<template>
<div id="app">
  <v-app>
    <v-content>
      <v-row>
        <v-col>
        <router-view />
        </v-col>
      </v-row>
    </v-content>
  </v-app>
</div>
</template>

<script>
export default {
  name: 'App',
}
</script>

<style>

</style>
