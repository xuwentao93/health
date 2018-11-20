<template>
  <div class='out'>
    <div class="leave">
      <div v-if="!ifLeave">
        <h3>请填写请假的相关信息</h3>
        <span>开始时间:</span>
        <el-select v-model="startMonth" @change='changeDay(1)'>
          <el-option v-for="month in months" :key="month" :value="month"></el-option>
        </el-select>月 
        <el-select v-model="startDay" :disabled="!startMonth">
          <el-option v-for="day in startDays.day" :key="day" :value="day"></el-option>
        </el-select>号<br>
        <span>结束时间:</span>
        <el-select v-model="overMonth" @change='changeDay(2)'>
          <el-option v-for="month in months" :key="month" :value="month"></el-option>
        </el-select>月 
        <el-select v-model="overDay" :disabled="!overMonth">
          <el-option v-for="day in overDays.day" :key="day" :value="day"></el-option>
        </el-select>号<br>
        <span>请假原因:</span><el-input v-model="reason"></el-input><br>
        <el-button type="success" @click='leave'>提交</el-button>
        <el-button type="primary" @click="reset">重置</el-button>
      </div>
      <div v-if="ifLeave">
        <h3>当前状态：请假中...</h3>
        <div class="leave-card">
          <span>开始时间：</span>
          <span>{{overDate.startMonth}}/{{overDate.startDay}}</span>
        </div>
        <div class="leave-card">
          <span>结束时间：</span>
          <span>{{overDate.overMonth}}/{{overDate.overDay}}</span>
        </div>
        <el-button type='warning' @click="showExtendtime">延长时间</el-button>
        <el-button type="success" @click="overAdvance">提前结束</el-button><br>
        <div v-if="extend" class='extend'>
          <el-select v-model="overMonth" @change='changeDay(2)'>
            <el-option v-for="month in months" :key="month" :value="month"></el-option>
          </el-select>月 
          <el-select v-model="overDay" :disabled="!overMonth">
            <el-option v-for="day in overDays.day" :key="day" :value="day"></el-option>
          </el-select>号<br>
          <el-button type="primary" @click="sumbitExtend">确认提交</el-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { leave, checkIfLeave, overAdvance } from "@/api/doctor";
import { year, month, day } from "@/config";
export default {
  data() {
    return {
      ifLeave: false,
      startMonth: "",
      startDay: "",
      overMonth: "",
      overDay: "",
      months: 12,
      startDays: {
        //必须用对象，接下来的方changeDay法中赋值字符串是两个，对象是一个。
        day: 31
      },
      overDays: {
        day: 31
      },
      reason: "",

      overDate: {
        startMonth: "",
        startDays: "",
        overMonth: "",
        overDay: ""
      },
      extend: false
    };
  },
  methods: {
    changeDay(index) {
      //1表示开始时间，2表示结束时间。
      let month = index == 1 ? this.startMonth : this.overMonth;
      let days = index == 1 ? this.startDays : this.overDays;
      if (
        month == 1 ||
        month == 3 ||
        month == 5 ||
        month == 7 ||
        month == 8 ||
        month == 10 ||
        month == 12
      ) {
        index == 1 ? (this.startDay = "") : (this.overDay = "");
        days.day = 31;
      } else if (month == 4 || month == 6 || month == 9 || month == 11) {
        index == 1 ? (this.startDay = "") : (this.overDay = "");
        days.day = 30;
      } else {
        index == 1 ? (this.startDay = "") : (this.overDay = "");
        const date = new Date();
        const year = date.getFullYear();
        if ((year % 4 == 0 && year % 100 != 0) || year % 400 == 0) days = 28;
        else days.day = 29;
      }
    },
    reset() {
      this.startMonth = "";
      this.startDay = "";
      this.overMonth = "";
      this.overDay = "";
      this.reason = "";
    },
    leave() {
      if (
        this.overMonth < this.startMonth ||
        (this.overMonth == this.startMonth && this.startDay > this.overDay)
      ) {
        alert("结束时间不能早于开始时间！");
        return;
      }
      if (this.reason == "") {
        alert("请假时间不能为空！");
        return;
      }
      if (
        this.overMonth < month ||
        (this.overMonth == month && this.overDay < day)
      ) {
        alert("结束日期不得小于当前日期！");
        return;
      }
      let checkLeave = confirm("确认要提交吗？");
      if (!checkLeave) return;
      leave({
        username: this.$store.state.user.user,
        startMonth:
          +this.startMonth < 10 ? "0" + this.startMonth : this.startMonth,
        startDay: +this.startDay < 10 ? "0" + this.startDay : this.startDay,
        overMonth: +this.overMonth < 10 ? "0" + this.overMonth : this.overMonth,
        overDay: this.overDay < 10 ? "0" + this.overDay : this.overDay
      })
        .then(res => {
          if (res.data == "success") {
            alert("请假成功！");
            location.reload();
          }
        })
        .catch(err => console.log(err));
    },
    checkIfLeave() {
      //检测医生是否请假，同时如果日期已经超过请假日期，医生显示为不请假。
      checkIfLeave({
        username: this.$store.state.user.user,
        month,
        day
      }).then(res => {
        if (res.data == "no") return;
        else {
          this.ifLeave = true;
          this.overDate.startMonth =
            res.data[0] < 10 ? "0" + res.data[0] : res.data[0];
          this.overDate.startDay =
            res.data[1] < 10 ? "0" + res.data[1] : res.data[1];
          this.overDate.overMonth =
            res.data[2] < 10 ? "0" + res.data[2] : res.data[2];
          this.overDate.overDay =
            res.data[3] < 10 ? "0" + res.data[3] : res.data[3];
        }
      });
    },
    overAdvance() {
      let checkOver = confirm("你确定要提前结束请假状态吗？");
      if (!checkOver) return;
      overAdvance({
        username: this.$store.state.user.user
      })
        .then(res => {
          if (res.data == "success") {
            alert("结束成功!");
            this.ifLeave = false;
          }
        })
        .catch(err => console.log(err));
    },
    showExtendtime() {
      this.extend = true;
    },
    sumbitExtend() {
      let extendCheck = confirm("确认要提交吗？");
      if (!extendCheck) return;
      leave({
        username: this.$store.state.user.user,
        startMonth: this.overDate.startMonth,
        startDay: this.overDate.startDay,
        overMonth: this.overMonth < 10 ? "0" + this.overMonth : this.overMonth,
        overDay: this.overDay < 10 ? "0" + this.overDay : this.overDay
      })
        .then(res => {
          if (res.data == "success") {
            alert("延长请假时间成功!");
            this.extend = false;
            this.checkIfLeave();
            this.overMonth = "";
            this.overDay = "";
          }
        })
        .catch(err => console.log(err));
    }
  },
  created() {
    this.checkIfLeave();
  }
};
</script>

<style scoped>
.el-select {
  margin: 0 10px 20px 10px;
  width: 20%;
}
.el-input {
  margin: 0 10px 20px 10px;
  width: 40%;
}
.el-button {
  margin: 0 40px;
}
.out{
  background: #f1f1f1;
}
.leave {
  width: 80%;
  height: 80vh;
  margin: 20px 0 0 60px;
  padding: 40px;
  border: 1px solid #ddd;
  border-radius: 3px;
  background: #fff;
  box-shadow: 1px 2px 8px #ccc;
}
.leave-card {
  margin: 10px;
  font-size: 20px;
  font-family: "time";
  color: #333;
}
.extend {
  margin-top: 30px;
}
</style>
