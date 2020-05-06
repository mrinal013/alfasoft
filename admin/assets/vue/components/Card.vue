<template>
  <div class="card">
    <span>{{ msg }}</span>
  </div>
</template>

<script>
export default {
  name: 'Card',
  data () {
    return {
      msg: 'I am card component'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
