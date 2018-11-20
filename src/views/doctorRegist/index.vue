<template>
  <div class="regist-page">
    <div class="regist">
      <div><span class='g-red'>*</span>用户名：</div>
      <div>
        <self-input v-model='username' @change='checkUser'></self-input>
        <span class="warn">{{userErr}}</span>
      </div>
      <div><span class='g-red'>*</span>密码：</div>
      <div>
        <self-input v-model='password' @change='checkPw' type='password'></self-input>
        <span class="warn">{{pwErr}}</span>
      </div>
      <div><span class='g-red'>*</span>确认密码：</div>
       <div>
        <self-input v-model='pwCheck' @change='checkPwCheck' type='password'></self-input>
        <span class="warn">{{checkPwErr}}</span>
      </div>
      <div><span class='g-red'>*</span>姓名：</div>
       <div>
        <self-input v-model='name' @change='checkName'></self-input>
        <span class="warn">{{nameErr}}</span>
      </div>
      <div><span class='g-red'>*</span>身份证号码：</div>
      <div>
        <self-input v-model='id' @change='checkId'></self-input>
        <span class="warn">{{idErr}}</span>
      </div>
      <div>
        <span class='g-red'>*</span><span>医院：</span>
      </div>
      <div>
        <el-select v-model='hospital'>
          <el-option v-for="hospital in hospitals" :key="hospital[0]" :value="hospital[0]"></el-option>
        </el-select>
        <span class="warn">{{hospitalErr}}</span>
      </div>
      <div>
        <span class='g-red'>*</span><span>科室：</span>
      </div>
      <div>
        <el-select v-model='department'>
          <el-option v-for="department in departments" :key="department[0]" :value="department[0]">
          </el-option>
        </el-select>
        <span class="warn">{{departmentErr}}</span>
      </div>
      <div><span class='g-red'>*</span>手机号码：</div>
      <div>
        <self-input v-model='phone' @change='checkPhone'></self-input>
        <span class="warn">{{phoneErr}}</span>
      </div>
      <div><self-input class='identifying' v-model='identify' @change='inspectIdentify'></self-input></div>
      <div>
        <el-button @click='identifying' :class='{permission:!permission}'>{{number}}</el-button>
        <span class="warn">{{identifyErr}}</span>
      </div>
      <div><span class="g-red">*</span>滑块验证：</div>
      <div>
        <self-slide></self-slide>
      </div>
      <div>
        <span class="g-red">*</span><span>医师证明：</span>
      </div>
      <div class='prove'>
        <input type="file" ref='img' class='prove-img' @change='checkPhoto'>
        <el-button class='prove-button' @click="handle">点击上传照片</el-button>
        <img :src="imgsrc" class='choosed-img' v-if='img'>
        <span class="warn img-warn">{{imgErr}}</span>
        <el-button size='mini' type='danger' class='close-img' v-if='img' @click='closeImg'>x</el-button>
      </div>
      <div>
        <el-button type='success' class='regist-button' @click='doctorRegist'>请求申请</el-button>
      </div>
      <div><el-button class='return-home' @click='toHome'>返回首页</el-button></div>
    </div>
  </div>
</template>
<script>
import {
  identifying,
  checkUser,
  checkTel,
  doctorRegist,
  checkHospital,
  checkDepartment
} from "@/api/login";
import { mapMutations } from "vuex";
import { setInterval } from "timers";
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
      name: "",
      id: "",
      phone: "",
      identify: "",
      hospital: "",
      userErr: "",
      pwErr: "",
      checkPwErr: "",
      nameErr: "",
      idErr: "",
      phoneErr: "",
      identifyErr: "",
      hospitalErr: "",
      number: "发送手机验证码",
      permission: true,
      checkIdentify: "",
      img: undefined,
      imgsrc: null,
      imgErr: "",
      hospitals: [],
      departments: [],
      departmentErr: "",
      department: ""
      // slideController: true
    };
  },
  methods: {
    ...mapMutations({
      setUser: "setUser",
      setToken: "setToken"
    }),
    handle() {
      this.$refs.img.click();
    },
    /**
     * @param {各种checkUser全部都是表单校验}
     */
    checkUser() {
      const firstnameExp = /^[a-zA-Z]$/; //定义用户名正则表达式匹配规则
      const nameExp = /^[a-zA-Z_0-9]{6,12}$/;
      if (this.username.length < 6 || this.username.length > 12) {
        this.userErr = "用户名不能小于6位或者大于12位";
      } else if (firstnameExp.exec(this.username.charAt(0)) == null) {
        this.userErr = "用户名首位必须是字母";
      } else if (nameExp.exec(this.username) == null) {
        this.userErr = "用户名只能为字母，数字，或者下划线";
      } else {
        checkUser({
          username: this.username
        }).then(res => {
          if (res.data == "用户名已存在") {
            this.userErr = "用户名已存在";
          } else this.userErr = "";
        });
      }
    },
    checkPw() {
      if (this.password.length < 8 || this.password.length > 16) {
        this.pwErr = "密码不能小于8位或者大于16位！";
      } else this.pwErr = "";
      if (this.password == this.pwCheck && this.password != "")
        this.checkPwErr = "";
    },
    checkPwCheck() {
      if (this.password != this.pwCheck) {
        this.checkPwErr = "两次密码不同！";
      } else this.checkPwErr = "";
    },
    checkName() {
      const nameExp = /^([\u4e00-\u9fa5]){2,4}$/;
      if (this.name.length < 2 || this.name.length > 4)
        this.nameErr = "姓名必须在2-4位!";
      else if (nameExp.exec(this.name) == null)
        this.nameErr = "姓名必须为中文！";
      else this.nameErr = "";
    },
    checkId() {
      const idExp = /^[0-9]{16}[0-9XY][0-9]$/;
      if (idExp.exec(this.id) == null) this.idErr = "身份证格式错误！";
      else this.idErr = "";
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
    checkHospital() {
      checkHospital()
        .then(res => {
          this.hospitals = res.data;
        })
        .catch(err => console.log(err));
    },
    checkDepartment() {
      checkDepartment()
        .then(res => {
          this.departments = res.data;
        })
        .catch(err => console.log(err));
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
      } else if (this.phoneErr == "") {
        let t = Math.floor(Math.random() * 10000);
        if (t < 10) t = "000" + t;
        else if (t < 100) t = "00" + t;
        else if (t < 1000) t = "0" + t;
        else t = "" + t;
        this.checkIdentify = t;
        this.phone = +this.phone;
        console.log(t);
        identifying({
          //短信验证码接口
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
    doctorRegist() {
      if (!this.username) this.userErr = "用户名不能为空！";
      else if (!this.password) this.pwErr = "密码不能为空";
      else if (!this.pwCheck) this.checkPwErr = "确认密码不能为空";
      else if (!this.name) this.nameErr = "姓名不能为空！";
      else if (!this.id) this.idErr = "身份证号码不能为空！";
      else if (!this.hospital) this.hospitalErr = "医院不能为空！";
      else if (!this.department) this.departmentErr = "科室不能为空！";
      else if (!this.phone) this.phoneErr = "手机号不能为空";
      else if (!this.identify) this.identifyErr = "验证码不能为空！";
      else if (!this.img) this.imgErr = "图片还未上传！";
      else if (this.checkIdentify != this.identify)
        this.identifyErr = "验证码错误！";
      // else if (this.slideController) {
      //   alert("请将滑块拖动到最右边加以验证！");
      // }
      if (
        this.userErr ||
        this.phoneErr ||
        this.checkPwErr ||
        this.pwErr ||
        this.identifyErr ||
        this.idErr ||
        this.nameErr ||
        this.hospitalErr ||
        this.imgErr ||
        this.departmentErr ||
        this.slideController
      )
        return;
      let data = new FormData(); //formdata 可以上传文件
      let username = this.username;
      let password = this.password;
      let name = this.name;
      let id = this.id;
      let tel = +this.phone;
      let hospital = this.hospital;
      let department = this.department;
      let level = this.$refs.img.files[0];
      let imgurl = level.name;
      data.append("file", level);
      data.append("username", username);
      data.append("password", password);
      data.append("name", name);
      data.append("id", id);
      data.append("tel", tel);
      data.append("department", department);
      data.append("hospital", hospital);
      data.append("level", level);
      data.append("url", imgurl);
      let url = "http://119.23.217.238/dist/saleApi/health/doctorregist.php";
      let XHR = new XMLHttpRequest();
      XHR.onreadystatechange = () => {
        if (XHR.readyState == 4 && XHR.status == 200) {
          alert("审核申请成功，请等待通知！");
          this.$router.push("/");
        }
      };
      XHR.open("POST", url);
      XHR.send(data);
    },
    toHome() {
      let t = confirm("确认要返回首页吗？");
      if (t == true) this.$router.push("/");
    },
    checkPhoto() {
      //将图片嵌在页面中
      this.img = this.$refs.img.files[0];
      const typeStr = /^(image\/jpg|image\/png|image\/gif|image\/jpeg)$/;
      if (typeStr.exec(this.img.type) == null) {
        this.imgErr = "请上传正确的图片格式！";
        this.img = "";
        return;
      }
      this.imgErr = "";
      let reads = new FileReader();
      reads.onloadend = e => {
        this.imgsrc = e.target.result;
      };
      reads.readAsDataURL(this.img);
    },
    closeImg() {
      this.img = "";
      this.$refs.img.value = "";
    }
  },
  created() {
    this.checkHospital();
    this.checkDepartment();
  }
};
</script>

<style lang='scss' scoped>
self-input {
  z-index: 2;
}
.el-select {
  width: 100%;
  z-index: 2;
}
.regist-page {
  width: 100%;
  height: calc(100vh + 330px);
  background: url("./bg.jpg") no-repeat;
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
  top: 50px;
  display: grid;
  grid-template-columns: 110px 330px;
  grid-template-rows: repeat(10, 60px) 300px 80px;
  width: 490px;
  height: 1000px;
  padding-top: 10px;
  border-radius: 5px;
  background: #fff;
  opacity: 0.9;
  div {
    position: relative;
    margin: 0;
    text-align: right;
    line-height: 45px;
  }
}
.identifying {
  position: relative;
  width: 200px;
  left: 80px;
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
  top: 20px;
  left: 80px;
  z-index: 2;
}
.return-home {
  position: relative;
  top: 20px;
  right: 60px;
}
.prove {
  border: 1px dotted #000;
  top: 15px;
  text-align: center;
  .prove-img {
    display: none;
  }
  .prove-button {
    position: absolute;
    top: 110px;
    left: 100px;
  }
  .choosed-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
  .img-warn {
    top: 277px;
  }
  .close-img {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
