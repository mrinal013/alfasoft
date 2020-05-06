<template>
  <div class="home">
    <span>{{ msg }}</span>
    <Card></Card>
  </div>
</template>

<script>
import Card from '../components/Card.vue';
export default {

  name: 'Home',
  components: {
    Card
  },

  data () {
    return {
      msg: 'Welcome to Your Vue.js Admin App'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
