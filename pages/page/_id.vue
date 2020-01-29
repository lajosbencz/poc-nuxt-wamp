<template>
    <div>
      <h1>{{ $route.params.id }}</h1>
      <p>{{ text }}</p>
    </div>
</template>

<script>
  export default {
    name: "pages-id",
    beforeRouteEnter(to, from, next) {
      next(async vm => {
        vm.text = await vm.$wamp.call('page', [vm.$route.params.id]);
      });
    },
    data() {
      return {
        text: '',
      };
    },
    async asyncData({app, route}) {
      return {
        text: await app.$wamp.call('page', [route.params.id]),
      };
    },
  }
</script>

<style>

</style>
