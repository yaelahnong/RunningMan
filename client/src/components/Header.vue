<template>
<div class="header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between">
      <h3><strong>{{ title[0] }}</strong> {{ title[1] }}</h3>
      <a href="" @click="onHandleLogout" @click.prevent class="text-light">Logout</a>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: {
    title: Array
  },
  methods: {
    onHandleLogout () {
      if (confirm('Are you sure?')) {
        localStorage.clear()
          .then(() => {
            this.$router.push('/login')
          })
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .header {
    position: absolute;
    width: 100%;
    h3 {
      color: #fff;
    }
    a {
      padding: 10px 20px;
    }
  }
</style>
