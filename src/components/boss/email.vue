<template>
  <div class="email">
    <span class='title'>申请列表</span><hr class='hr'>
    <div v-for='(msg,index) in msgs' :key='msg.username' class='self-msg'>
      <span class='name' @click='toggle(index)'> {{msg.name}} 
        <i class='fa fa-angle-down' :class={rotate:rotate[index]}></i>
      </span>
      <div class="msg" :class={showMsg:rotate[index]}>
        <span>用户名： {{msg.username}}</span>
        <span>姓名： {{msg.name}}</span>
        <span>身份证号码： {{msg.idnumber}}</span>
        <span>手机号： {{msg.tel}}</span>
        <span>就诊医院： {{msg.hospital}}</span>
        <span>科室： {{msg.department}}</span>
        <span>医师证明： </span>
        <div><img :src="msg.level" class='prove'></div>
        <div>
          <el-button type='success' @click='addDoctor(msg.username)'>通过</el-button>
          <el-button @click='removeDoctor(msg.username)'>不通过</el-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { showMsg, addDoctor, removeDoctor } from "@/api/boss";
import { arrToObj } from "@/utils/arrs";
export default {
  data() {
    return {
      rotate: [], //默认是undefined，就不用设置false
      msgs: []
    };
  },
  methods: {
    toggle(index) {
      this.$set(this.rotate, index, !this.rotate[index]);
    },
    showMsg() {
      showMsg()
        .then(res => {
          arrToObj(
            res.data,
            "username",
            "tel",
            "name",
            "idnumber",
            "hospital",
            "level",
            "department"
          );
          this.msgs = res.data;
          this.msgs.forEach(index => {
            index.level = `http://119.23.217.238/dist/saleApi/health/img/${
              index.level
            }`;
          });
        })
        .catch(err => console.log(res.err));
    },
    addDoctor(username) {
      let check = confirm("确认信息属实后，点击确定予以通过。");
      if (check) {
        addDoctor({
          username
        })
          .then(res => {
            removeDoctor({
              username
            }).then(res => {
              this.showMsg();
              alert("操作成功！");
              this.$store.state.email.number--;
            });
          })
          .catch(err => console.log(err));
      }
    },
    removeDoctor(username) {
      let check = confirm("确定要拒绝该名医生的注册吗？");
      if (check) {
        removeDoctor({
          username
        })
          .then(res => {
            console.log(this);
            this.showMsg();
            alert("操作成功");
            this.$store.state.email.number--;
          })
          .then(err => console.log(err));
      }
    }
  },
  mounted() {
    this.showMsg();
  }
};
</script>

<style scoped lang='scss'>
.email {
  position: relative;
}
.self-msg {
  width: 40%;
  padding: 1px 0 5px 8px;
  margin-bottom: 10px;
  border: 1px solid #ddd;
  border-radius: 3px;
  background: #fff;
  box-shadow: 1px 2px 3px #ccc;
}
.title {
  display: inline-block;
  margin-bottom: 10px;
  color:#f00;
}
.fa-angle-down {
  font-weight: 700;
  transition: all 0.4s;
}
.rotate {
  transform: rotate(180deg);
}
.title,
.name {
  font-weight: 700;
  font-size: 17px;
}
.name {
  cursor: pointer;
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
  position: relative;
  top: 15px;
  display: grid;
  grid-template-columns: 400px;
  grid-template-rows: repeat(6, 40px);
  height: 0;
  overflow: hidden;
  transition: all 0.5s;
}
.showMsg {
  height: 615px;
}
.prove {
  position: relative;
  right: 8px;
  width: 100%;
  height: 300px;
}
</style>
