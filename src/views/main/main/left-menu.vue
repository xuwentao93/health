<template>
    <div class="left">
        <ul class='menu'>
          <span v-for='(menu,index) in menus' :key='menu.name' >
            <li :class='{bgstyle:menu.selected}' @click='checkSelect(index)' 
            v-if='$store.state.user.token ==menu.permission || menu.permission =="all"'>
                <router-link :to='`/main/${menu.url}`'>{{menu.name}}</router-link>
                <span class='circle' v-if='menu.name=="医生注册申请" && !iszero'>
                  {{$store.state.email.number}}
                </span>
            </li>
          </span>
        </ul>
    </div>
</template>

<script>
import { showMsg } from "@/api/boss";
import { menus } from '@/config';
export default {
  data() {
    return {
      menus,
      number: "",
      iszero: false,
    };
  },
  methods: {
    checkSelect(index) {
      this.menus.forEach(value => {
        value.selected = false;
      });
      this.menus[index].selected = true;
    }
  },
  created() {
    this.menus.forEach(item => {  //这个方法用于刷新的时候，子菜单的背景色不会褪去。
      if (this.$route.name === item.url) {
        this.$set(item, "selected", true);
        return;
      }
    });
    if (this.$store.state.user.token == "boss") {
      showMsg()
        .then(res => {
          this.$store.state.email.number = res.data.length;
          if (this.$store.state.email.number == 0) this.iszero = true;
        })
        .catch(err => console.log(err));
    }
  }
};
</script>

<style scoped lang='scss'>
.left {
  background:rgb(43,54,71) url("logo.png") no-repeat 50% 30px;
  background-size: 130px 130px;
  
}
.menu {
  position: relative;
  top: 150px;
}
.menu li {
  position: relative;
  display: inline-block;
  box-sizing: border-box;
  width: 100%;
  height: 45px;
  line-height: 45px;
  text-align: center;
  // background: #333;
  transition: all 0.2s;
}
.menu a {
  display: inline-block;
  width: 100%;
  box-sizing: border-box;
  color:rgb(160,171,191);
  transition: all 0.2s;
  // font-family: "dictionary";
  &:hover {
    color: #fff;
  }
}
.bgstyle {
  background: #202739 !important;
  a {
    color: #fff !important;
  }
}
.circle {
  position: absolute;
  top: 10px;
  right: 7%;
  display: inline-block;
  width: 20px;
  height: 20px;
  border-radius: 10px;
  line-height: 20px;
  background: #409eff;
  color: #fff;
}
</style>
