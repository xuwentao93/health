<template>
  <div>
    <div>
      <span class='title'>个人信息</span><hr class='hr'>
      <div class="msg">
        <div class="title">基本信息</div>
        <table>
          <tr>
            <td>用户名：{{msg.username}}</td>
            <td>姓名：{{msg.name}}</td>
          </tr>
          <tr>
            <td>身份证：{{msg.idnumber}}</td>
            <td>手机号：{{msg.tel}}</td>
          </tr>
          <tr>
            <td>性别：{{sex}}</td>
            <td>年龄：{{age}}</td>
          </tr>
        </table>
      </div>
      <div class="msg doctor-msg" v-if='$store.state.user.token === "doctor"'>
        <div class="title">医生信息</div>
        <table>
          <tr>
            <td>医生等级：{{msg.level}}</td>
            <td>医院：{{msg.hospital}}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { selectMsg } from "@/api/msg";
import { arrToObj } from "@/utils/arrs";
export default {
  data() {
    return {
      user: this.$store.state.user.user,
      token: this.$store.state.user.token,
      msg: {},
      number: "",
      sex: "",
      age: ""
    };
  },
  methods: {
    selectMsg() {
      let msg;
      selectMsg({
        user: this.user
      }).then(res => {
        if (this.token != "doctor") {
          msg = {
            username: this.user,
            idnumber: res.data[0],
            name: res.data[1],
            tel: res.data[2]
          };
          this.msg = msg;
        } else {
          msg = {
            username: this.user,
            idnumber: String(res.data[0]), //之后的+号就可以变成字符串拼接
            name: res.data[1],
            tel: res.data[2],
            level: res.data[3],
            hospital: res.data[4]
          };
        }
        const date = new Date();
        const year = date.getFullYear();
        const month = date.getMonth() + 1;
        const day = date.getDate();
        const num = msg.idnumber;
        const y = num[6] + num[7] + num[8] + num[9]; //num是字符串，身份证号，不是数组。
        let age = {
          year: year - +y,
          month: month - +(num[10] + num[11]),
          day: day - +(num[12] + num[13])
        };
        this.age = age.year;
        if (age.month < 0) age--;
        else {
          if (age.day < 0) age--;
        }
        this.sex = num[16] == "x" || +num[16] % 2 == 1 ? "男" : "女";
        this.msg = msg;
      });
    }
  },
  created() {
    this.selectMsg();
  }
};
</script>

<style scoped lang='scss'>
.body {
  background: #f1f1f1;
}
.title {
  font-weight: 700;
  font-size: 22px;
  color: #444;
  font-family: "time";
}
.hr {
  position: relative;
  top: 1px;
  display: inline-block;
  width: 40%;
  border: transparent;
  border-top: 1px solid #909399;
}
.msg {
  width: 80%;
  height: 180px;
  margin: 20px 0 0 20px;
  padding: 6px;
  background: #fff;
  box-shadow: 1px 2px 3px #ccc;
  td {
    min-width: 300px;
    height: 36px;
    font-size: 16px;
    line-height: 36px;
    color: #a7a7a7;
    margin-bottom: 20px;
  }
}
.doctor-msg {
  height: 100px;
}
</style>
