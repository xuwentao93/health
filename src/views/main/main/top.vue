<template>
  <div class="top">
    <div class="title">医疗健康状态查询系统</div>
    <div class="user">欢迎你，<span class='g-red'>{{$store.state.user.user}}</span></div>
    <div class="login-out" @click='loginOut'><i class="fa fa-sign-in" aria-hidden="true"></i>登出</div>
  </div>
</template>

<script>
import { removeUser, removeToken } from "@/utils/localStorage";
import { setTimeout } from "timers";
export default {
  data() {
    return {};
  },
  methods: {
    loginOut() {
      let t = confirm("确认要登出吗?");
      if (t == false) return;
      else {
        removeUser();
        removeToken();
        this.$router.push("/");
      }
    }
  },
  beforeCreate() {
    if (this.$store.state.user.user == null) {
      alert("您还未登录，请先登录！");
      this.$router.push("/");
    }
    if (this.$store.state.user.token == "custom") {
      setTimeout(() => {
        removeUser();
        removeToken();
        alert("您登录已超过30分钟，为了保障您的账号安全，请重新登录！");
        this.$router.push("/");
      }, 1800000);
    }
  }
};
</script>

<style scoped lang='scss'>
.top{
  background: #fff;
  color:#455;
}
.top > div {
  display: inline-block;
  height: 80px;
  vertical-align: top;
  line-height: 60px;
}
.logo {
  width: 100px;
  height: 60px;
  //background: url("./logo.jpg") no-repeat;
  //background-size:100% 100%;
}
.title{
  font-size:25px;
  letter-spacing: 5px;
  color:#f00;
  font-family: "zhong shan"
}
.user {
  position: absolute;
  right: 10%;
  font-size: 18px
}
.login-out {
  position: absolute;
  right: 0;
  padding: 0 2%;
  height: inherit !important;
  border:2px solid transparent;
  font-size:18px;
  cursor: pointer;
  transition: all .2s linear;
  &:hover {
    // color: #f00;
    background: #eef1f6;
    border-bottom:2px solid #2c8;
  }
}
.g-red {
  color: #f00;
}
</style>
