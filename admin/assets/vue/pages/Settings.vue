<template>
  <div class="app-settings">
    The Settings Page
    <List></List>
  </div>
</template>

<script>
import List from '../components/List.vue';
export default {

  name: 'Settings',
  components: {
    List
  },

  data () {
    return {

    };
  }
};
</script>

<style lang="css" scoped>
</style>
