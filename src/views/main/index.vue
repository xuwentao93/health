<template>
    <div class="main">
        <left-menu class='left-menu'></left-menu>
        <basic class='basic'></basic>
        <top class='top'></top>
    </div>
</template>

<script>
import top from "@/views/main/main/top";
import leftMenu from "@/views/main/main/left-menu";
import basic from "@/views/main/main/basic";
export default {
  components: {
    top,
    basic,
    leftMenu
  }
};
</script>

<style scoped lang='scss'>
.main{
  position: relative;
}
.top {
  position: fixed;
  top:0;
  left:18%;
  width: 82%;
  height: 60px;
  padding-left:25px;
  box-shadow: 0 2px 8px #f0f1f2;
  background: #fff //必须设置，否则email看起来会盖在top上。（默认是transparent）
}
.left-menu {
  position: fixed;
  z-index: 2;
  top: 0px;
  width: 18%;
  min-width: 200px;
  height: 100vh;
  padding-top:30px;
  background: #fff;
}
.basic {
  position: relative;
  top:60px;
  padding:20px 0 0 20%;
  min-height: calc(100vh - 60px);
  background: #f1f1f1;
}
</style>
