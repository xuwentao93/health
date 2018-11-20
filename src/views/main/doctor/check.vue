<template>
  <div class='out'>
    <div class="check">
      <span>选择时间：</span>
      <el-select v-model="time" @change='reserved'>
        <el-option v-for="time in timeList" :key='time' :value='time'></el-option>
      </el-select>
      <span v-if='username'>姓名：{{username}}</span>
      <span v-if='name'>姓名：{{name}}</span>
      <span v-if='noCustom' class='g-red'>该时间段还没有病人预约！</span><br>
      <span>检查内容：</span>
      <el-select v-model='check'>
        <el-option v-for='check in checks' :key='check' :value='check'></el-option>
      </el-select>
      <el-button type='primary' @click='addCheck'>确认</el-button>
    </div>
  </div>
</template>

<script>
import { timeList, year, month, day } from "@/config";
import { reserved, selectCheck, addCheck } from "@/api/doctor";
export default {
  data() {
    return {
      username: "",
      name: "",
      noCustom: false,
      nameErr: "",
      time: "",
      timeList,
      check: "",
      checks: []
    };
  },
  methods: {
    reserved() {
      reserved({
        doctor: this.$store.state.user.user,
        time: this.time
      })
        .then(res => {
          if (res.data === "none") {
            this.noCustom = true;
            this.name = "";
            this.username = "";
          } else {
            this.noCustom = false;
            this.username = res.data[0];
            this.name = res.data[1];
          }
        })
        .catch(err => console.log(err));
    },
    selectCheck() {
      selectCheck().then(res => {
        this.checks = res.data;
      });
    },
    addCheck() {
      if (!this.name) {
        alert("请选择要检查的病人！");
        return;
      }
      if(!this.check) {
        alert("请选择要检查的项目！");
        return;
      }
      const check = confirm("确认要提交吗？");
      if (!check) return;
      addCheck({
        custom: this.username,
        check: this.check
      })
        .then(res => {
          alert("检查申请成功!");
          this.$router.push("/main/cure");
        })
        .catch(err => console.log(err));
    }
  },
  mounted() {
    this.selectCheck();
  }
};
</script>

<style scoped>
.g-red {
  color: #f00;
}
.el-select {
  margin: 0 20px 20px 0;
}
.out {
  background: #f1f1f1;
}
.check {
  width: 80%;
  height: 80vh;
  margin: 20px 0 0 60px;
  padding: 40px;
  border: 1px solid #ddd;
  border-radius: 3px;
  background: #fff;
  box-shadow: 1px 2px 8px #ccc;
}
</style>
