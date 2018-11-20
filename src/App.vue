<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style lang='scss'>
@import './styles/index.css'; //修改默认样式。
@import "./styles/font.css"; //引入字体。
</style>
