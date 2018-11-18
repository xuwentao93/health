<template>
  <div class="login-page">
    <!-- <div class="doctor-flag"></div> -->
    <div class="login-form">
      <div class="title">欢迎登录！</div>
      <img src="./logo.png" class='logo'>
      <div>
        <i class="fa fa-user-o"></i>
        <self-input placeholder="请输入用户名" v-model='username' @change="checkUser" style="width:70%">
        </self-input>
        <span class='warn'>{{userErr}}</span>
        <!-- <i class="fa fa-user-o login-icon"></i> -->
        </div>
      <div>
        <i class="fa fa-eye"></i>
        <self-input placeholder="请输入密码" v-model='password' type='password' @change="checkPw"
         @enter='login' style='width:70%;'></self-input>
        <span class='warn'>{{pwErr}}</span>
        <!-- <i class="fa fa-eye login-icon"></i> -->
        </div>
        <el-button type='primary' class='login-button' @click='login'>登录</el-button>
        <div>
          <router-link to='/regist' class='regist'>注册</router-link>
          <router-link to='/forget' class='forget'>忘记密码</router-link>
        </div>
        <div>
          <el-button type='success' class='doctor-regist'>
            <router-link to='/doctorRegist' class='doctor-regist-link'>医生账号注册</router-link>
          </el-button>
        </div>
        <div class='breif'>Copyright © 2017-2017 特别鸣谢管理员对本页面的贡献</div>
    </div>
  </div>
</template>

<script>
import { login } from "@/api/login";
import { removeUser, removeToken } from "@/utils/localStorage";
import { mapMutations } from "vuex";
import selfInput from "@/components/selfInput";
export default {
  components: {
    selfInput
  },
  data() {
    return {
      username: "",
      password: "",
      userErr: "",
      pwErr: ""
    };
  },
  methods: {
    ...mapMutations({
      setUser: "setUser",
      setToken: "setToken"
    }),
    checkUser() {
      const firstnameExp = /^[a-zA-Z]$/; //定义用户名正则表达式匹配规则
      const nameExp = /^[a-zA-Z_0-9]{6,12}$/;
      if (this.username.length < 6 || this.username.length > 12) {
        this.userErr = "用户名不能小于6位或者大于12位";
      } else if (firstnameExp.exec(this.username.charAt(0)) == null) {
        this.userErr = "用户名首位必须是字母";
      } else if (nameExp.exec(this.username) == null) {
        this.userErr = "用户名只能为字母，数字，或者下划线";
      } else this.userErr = "";
    },
    checkPw() {
      if (this.password.length < 8 || this.password.length > 16) {
        this.pwErr = "密码不能小于8位或者大于16位！";
      } else this.pwErr = "";
    },
    login() {
      if (!this.username) {
        this.userErr = "用户名不能为空！";
        return;
      } else if (this.password == "") {
        this.pwErr = "密码不能为空！";
      } else if (this.pwErr == "" && this.userErr == "") {
        login({
          username: this.username,
          password: this.password
        })
          .then(res => {
            if (res.data == "wrong") {
              alert("用户名或密码错误！");
              return;
            } else {
              const response = {
                //返回的格式以对象储存
                username: res.data[0],
                permission: res.data[1]
              };
              this.setUser(response.username);
              this.setToken(response.permission);
              this.$router.push("/main");
            }
          })
          .catch(err => console.log(err));
      }
    }
  },
  mounted() {}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang='scss'>
el-input,
el-button {
  z-index: 2;
}
.self-input{
  width:70%;
}
.login-page {
  width: 100%;
  height: 100vh;
  background: url("./bg.jpg") no-repeat;
  background-size: 100% 100%;
}
.login-form {
  position: absolute;
  left: 50%;
  top: 100px;
  width: 500px;
  height: 476px;
  margin-left:-250px;
  padding: 20px;
  border-radius: 5px;
  background: #fff;
  > div {
    position: relative;
    margin-bottom: 20px;
    .login-icon {
      position: absolute;
      top: 13px;
      left: 4px;
      font-size: 12px;
      color: #909399;
    }
  }
  .fa{
    margin-left:30px;
    margin-right:10px;
    font-size:18px;
    color:#99a;
  }
  .fa-eye{
    margin-right:8px;
  }
  .logo{
    height:60px;
  }
  .title {
    margin: 0 auto;
    width: 140px;
    margin-bottom: 8px;
    font-size: 20px;
    color: #f00 ;
    font-family:"zhong shan";
    font-size:28px;
    font-weight:600
  }
  .warn {
    position: absolute;
    left:14%;
    top:43px;
    font-size: 13px;
    color: #f00;
  }
  .login-button {
    display: block;
    margin: 0 auto;
    margin-bottom: 20px;
    width: 74%;
  }
  .regist,
  .forget {
    color: #909399;
    &:hover {
      color: #f00;
    }
  }
  .regist{
    position: relative;
    left:14%;
  }
  .forget {
    position: absolute;
    right: 14%;
  }
  .doctor-regist {
    display: block;
    width: 74%;
    height: 40px;
    padding: 0;
    margin:0 auto;
    &:hover {
      transform: scale(1.02);
    }
    .doctor-regist-link {
      display: inline-block;
      width: 100%;
      height: 40px;
      line-height: 40px;
      color: #fff;
    }
  }
  .breif{
    position: relative;
    top:30px;
    margin:auto;
    width:70%;
    font-size:12px;
    color:#99a
  }
}
</style>
