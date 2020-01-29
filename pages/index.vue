<template>
  <div class="container">
    <div>
      <logo />
      <h1 class="title">
        poc-nuxt-wamp
      </h1>
      <h2 class="subtitle">
        Proof of Concept NuxtJS WAMP plugin
      </h2>
      <p>
        <span> {{ time }}</span>
        <br/>
        <span> {{ time2 }}</span>
      </p>
      <div class="links">
        <a
          href="https://nuxtjs.org/"
          target="_blank"
          class="button--green"
        >
          Documentation
        </a>
        <a
          href="https://github.com/nuxt/nuxt.js"
          target="_blank"
          class="button--grey"
        >
          GitHub
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import Logo from '~/components/Logo.vue'
const sleep = ms => new Promise(r => setTimeout(r, ms));
export default {
  components: {
    Logo
  },
  data() {
    return {
      time: '',
      time2: '',
    };
  },
  async asyncData({app}) {
    const time = await app.$wamp.call('time');
    await sleep(1000);
    const time2 = await app.$wamp.call('time');
    return {
      time,
      time2,
    };
  },
  mounted() {

  },
}
</script>

<style>
.container {
  margin: 0 auto;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.title {
  font-family: 'Quicksand', 'Source Sans Pro', -apple-system, BlinkMacSystemFont,
    'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  display: block;
  font-weight: 300;
  font-size: 100px;
  color: #35495e;
  letter-spacing: 1px;
}

.subtitle {
  font-weight: 300;
  font-size: 42px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}
</style>
