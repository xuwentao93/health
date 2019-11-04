<template>
  <div class='outer'>
    <div>
      <span class='title'>个人信息</span>
      <!-- <td></td>
            <td>姓名：{{msg.name}}</td>
            <td>身份证：{{msg.idnumber}}</td>
            <td>手机号：{{msg.tel}}</td>
            <td>性别：{{sex}}</td>
            <td>年龄：{{age}}</td>
        <div class="msg doctor-msg" v-if='$store.state.user.token === "doctor"'>
        <div class="title">医生信息</div>
            <td>医生等级：{{msg.level}}</td>
            <td>医院：{{msg.hospital}}</td>
            <td>科室：{{msg.department}}</td>
      </div> -->
      <div class="msg first-msg">
        <div class="icon">
          <i class="fa fa-user-o"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>用户名：</span><span>{{msg.username}}</span>
          </span><br>
          <span class='g-red'>用户名是唯一的凭证，请牢记！</span>
        </div>
      </div>
        <div class="msg">
        <div class="icon">
          <i class="fa fa-id-card"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>身份证号码：</span><span>{{msg.idnumber}}</span>
          </span>
        </div>
      </div>
      <div class="msg">
        <div class="icon">
          <i class="fa fa-male"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>姓名：</span><span>{{msg.name}}</span>
          </span>
        </div>
      </div>
      <div class="msg">
        <div class="icon">
          <i class="fa fa-mobile"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>手机号：</span><span>{{msg.tel}}</span>
          </span>
        </div>
      </div>
      <!-- <div class="msg">
        <div class="icon">
          <i class="fa fa-user-o"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>年龄：</span><span>{{age}}</span>
          </span>
        </div>
      </div> -->
     <!-- <div class="msg">
        <div class="icon">
          <i class="fa fa-user-o"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>性别：</span><span>{{sex}}</span>
          </span>
        </div>
      </div> -->
      <div class="msg" v-if='$store.state.user.token == "doctor"'>
        <div class="icon">
          <i class="fa fa-user-md"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>医生等级：</span><span>{{msg.level}}</span>
          </span>
        </div>
      </div>
      <div class="msg" v-if='$store.state.user.token == "doctor"'>
        <div class="icon">
          <i class="fa fa-hospital-o"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>医院：</span><span>{{msg.hospital}}</span>
          </span>
        </div>
      </div>
      <div class="msg" v-if='$store.state.user.token == "doctor"'>
        <div class="icon">
          <i class="fa fa-microchip"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>科室：</span><span>{{msg.department}}</span>
          </span>
        </div>
      </div>
      <div class="msg">
        <div class="icon">
          <i class="fa fa-commenting-o"></i>
        </div>
        <div class='breif'>
          <span>
            <span class='property'>社交账号</span><br>
            <span class='g-brief'>绑定第三方账号，可以直接登录，还可以将内容同步到以下平台，与更多好友分享</span>
          </span>
        </div>
      </div>
      <div class="society">
        <div class="wechat">
          <div class="circle">
            <i class="fa fa-wechat"></i>
          </div>
          <div class='brief'>
            <span class='tab'>微信</span><br>
            <span class='g-brief'>未绑定</span><br>
            <span class='g-red'>此功能尚未开通，尽情期待！</span>
          </div>
        </div>
        <div class="qq">
          <div class="circle g-blue">
            <i class="fa fa-qq"></i>
          </div>
          <div class='brief'>
            <span class='tab'>QQ</span><br>
            <span class='g-brief'>未绑定</span><br>
            <span class='g-red'>此功能尚未开通，尽情期待！</span>
          </div>
        </div>
        <div class="sina">
          <div class="circle back-orange">
            <i class="fa fa-weibo" style='color: rgb(240,21,28)'></i>
          </div>
          <div class='brief'>
            <span class='tab'>微博</span><br>
            <span class='g-brief'>未绑定</span><br>
            <span class='g-red'>此功能尚未开通，尽情期待！</span>
          </div>
        </div>
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
            hospital: res.data[4],
            department: res.data[5]
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
.outer {
  padding: 40px 0 0 420px;
}
.title {
  font-weight: 700;
  font-size: 22px;
  color: #444;
  font-family: "time";
}
.first-msg {
  margin-top: 12px;
}
.msg {
  margin-left: 1%;
  width: 800px;
  height: 60px;
  // line-height: 0;
  overflow: hidden;
  border-top: 1px solid #d9dde1;
  .icon {
    width: 84px;
    float: left;
    font-size: 24px;
    color: #d9dde1;
    text-align: center;
    // color:#000;
    line-height: 60px;
  }
  .breif {
    padding-top: 10px;
    width: 80%;
    float: left;
  }
  .property {
    font-weight: 700;
    font-size: 16px;
    color: #2b333b;
  }
}
.society {
  margin: 20px 0 0 80px;
  .circle {
    display: inline-block;
    width: 80px;
    height: 80px;
    margin-bottom:20px;
    border-radius: 40px;
    line-height: 100px;
    background: #67c23a;
    text-align: center;
    .fa {
      font-size: 45px;
      color: #fff;
    }
  }
  .tab{
    font-weight: 700;
    font-size: 16px;
  }
  .brief{
    display: inline-block;
  }
}
.wechat,.sina,.qq{
  display: inline-block;
}
.g-brief {
  color: #99a;
}
.g-red{
  color:#f00;
}
.g-blue{
  background: #49f !important
}
.back-orange{
  background:rgb(250, 219, 119) !important
}
</style>
