<template>
  <div class="regist-page">
    <div class="regist">
      <div><span class='g-red'>*</span>用户名：</div>
      <div>
        <self-input v-model='username' @change='checkUser'></self-input>
        <span class="warn">{{userErr}}</span>
      </div>
      <div><span class='g-red'>*</span>新密码：</div>
      <div>
        <self-input v-model='password' @change='checkPw' type='password'></self-input>
        <span class="warn">{{pwErr}}</span>
      </div>
      <div><span class='g-red'>*</span>确认密码：</div>
      <div>
        <self-input v-model='pwCheck' @change='checkPwCheck' type='password'></self-input>
            <span class="warn">{{checkPwErr}}</span>
      </div>
      <div><span class="g-red">*</span>滑块验证：</div>
      <div>
        <self-slide style='position:relative;top:8.5px;'></self-slide>
      </div>
      <div><span class='g-red'>*</span>手机号码：</div>
      <div>
        <self-input v-model='phone' @change='checkPhone'></self-input>
        <span class="warn">{{phoneErr}}</span>
      </div>
      <div>
        <self-input class='identifying' v-model='identify' @change='inspectIdentify'></self-input>
      </div>
      <div>
        <el-button @click='identifying' :class='{permission:!permission}'>{{number}}</el-button>
        <span class="warn">{{identifyErr}}</span>
      </div>
      <div>
        <el-button type='success' class='regist-button' @click='modifySecret'>注册</el-button>
      </div>
      <div><el-button class='return-home' @click='toHome'>首页</el-button></div>
    </div>
  </div>
</template>
<script>
import {
  identifying,
  checkTel,
  modifySecret,
  registMsg
} from "@/api/login";
import { mapMutations } from "vuex";
import selfInput from "@/components/selfInput";
import selfSlide from "@/components/selfSlide";
export default {
  components: {
    selfInput,
    selfSlide
  },
  data() {
    return {
      username: "",
      password: "",
      pwCheck: "",
      phone: "",
      identify: "",
      userErr: "",
      pwErr: "",
      checkPwErr: "",
      phoneErr: "",
      identifyErr: "",
      number: "发送手机验证码",
      permission: true,
      checkIdentify: ""
    };
  },
  methods: {
    checkUser() {
      const firstnameExp = /^[a-zA-Z]$/; // 定义用户名正则表达式匹配规则
      const nameExp = /^[a-zA-Z_0-9]{6,12}$/;
      if (this.username.length < 6 || this.username.length > 12) {
        this.userErr = "用户名不能小于6位或者大于12位";
      } else if (firstnameExp.exec(this.username.charAt(0)) == null) {
        this.userErr = "用户名首位必须是字母";
      } else if (nameExp.exec(this.username) == null) {
        this.userErr = "用户名只能为字母，数字，或者下划线";
      }
    },
    checkPw() {
      if (this.password.length < 8 || this.password.length > 16) {
        this.pwErr = "密码不能小于8位或者大于16位！";
      } else this.pwErr = "";
      if (this.password == this.pwCheck && this.password) this.checkPwErr = "";
    },
    checkPwCheck() {
      if (this.password != this.pwCheck) {
        this.checkPwErr = "两次密码不同！";
      } else this.checkPwErr = "";
    },
    checkPhone() {
      const phoneExp = /^1[34578]\d{9}$/;
      if (this.phone.length != 11) this.phoneErr = "手机号必须为11位！";
      else if (phoneExp.exec(this.phone) == null)
        this.phoneErr = "手机号格式不正确！";
      else {
        checkTel({
          tel: this.phone
        }).then(res => {
          if (res.data == "该手机号已被注册") {
            this.phoneErr = "该手机号已被注册";
          } else this.phoneErr = "";
        });
      }
    },
    inspectIdentify() {
      if (this.identify == this.checkIdentify && this.identify != "") {
        this.identifyErr = "";
      }
    },
    identifying() {
      if (this.permission == false) {
        return;
      }
      if (this.phone == "") {
        this.phoneErr = "手机号不能为空！";
        return;
      } else if (this.phoneErr) return;
      else if (this.phoneErr == "") {
        let t = Math.floor(Math.random() * 10000);
        if (t < 10) t = "000" + t;
        else if (t < 100) t = "00" + t;
        else if (t < 1000) t = "0" + t;
        else t = "" + t;
        this.checkIdentify = t;
        this.phone = +this.phone;
        console.log(this.checkIdentify);
        identifying({
          sid: "46f7f9e42752e6a89a5e11799b1f90fb",
          token: "0e7bca95cbd8147117777046d6d4adfd",
          appid: "949b1a0754ee48cbb6fa11fc244d295a",
          templateid: "389651",
          yzm: t,
          yzmtel: +this.phone
        })
          .then(res => {
            this.permission = false;
            let n = 60; //定时
            let t = setInterval(() => {
              this.number = `${n}秒后可在次发送`;
              n--;
              if (n < 0) {
                this.permission = true;
                this.number = "发送手机验证码";
                clearInterval(t);
              }
            }, 1000);
          })
          .catch(err => console.log(err));
      }
    },
    modifySecret() {
      if (!this.username) this.userErr = "用户名不能为空！";
      else if (!this.password) this.pwErr = "密码不能为空";
      else if (!this.pwCheck) this.checkPwErr = "确认密码不能为空";
      else if (!this.phone) this.phoneErr = "手机号不能为空";
      else if (!this.identify) this.identifyErr = "验证码不能为空！";
      else if (this.checkIdentify != this.identify)
        this.identifyErr = "验证码错误！";
      if (
        this.userErr ||
        this.phoneErr ||
        this.checkPwErr ||
        this.pwErr ||
        this.identifyErr
      )
        return;
      modifySecret({
        username:this.username,
        password:this.password
      })
      .then(()=>{
        alert("密码修改成功！");
        this.$router.push("/");
      })
    },
    toHome() {
      let t = confirm("确认要返回首页吗？");
      if (t == true) this.$router.push("/");
    }
  }
};
</script>

<style lang='scss' scoped>
self-input {
  z-index: 2;
}
.regist-page {
  width: 100%;
  height: 100vh;
  background: url("./regist.jpg") no-repeat;
  background-size: 100% 100%;
}
.g-red {
  color: red;
}
.warn {
  position: absolute;
  left: 0;
  top: 30px;
  font-size: 13px;
  color: #f00;
}
.regist {
  position: absolute;
  left: 50%;
  margin-left: -250px;
  top: 140px;
  display: grid;
  grid-template-columns: 110px 330px;
  grid-template-rows: repeat(4, 60px);
  width: 490px;
  height: 470px;
  border-radius: 5px;
  background: #fff;
  opacity: 0.9;
  div {
    position: relative;
    margin: 0;
    text-align: right;
    line-height: 60px;
  }
}
.identifying {
  position: relative;
  width: 200px;
  left: 50px;
  z-index: 2;
}
.permission {
  border-color: #dcdfe6;
  background: #fff;
  color: #909399;
  cursor: not-allowed;
}
.regist-button {
  position: relative;
  top: -10px;
  left: 80px;
  z-index: 2;
}
.return-home {
  position: relative;
  top: -10px;
  right: 70px;
}
</style>
