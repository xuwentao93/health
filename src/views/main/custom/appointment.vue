<template>
  <div>
    <div class="appointment">
      <span>科室：</span>
      <el-select v-model="department" class='el-select' @change="selectDoctor">
        <el-option v-for='department in departments' :key='department' :value="department"></el-option>
      </el-select><br>
      <span>地区：</span>
      <el-select v-model="city" class='el-select' @change="selectHospital">
       <el-option v-for='city in citys' :key='city' :value="city"></el-option>
      </el-select><br>
      <span>医院：</span>
      <el-select v-model="hospital" class='el-select' :disabled="!city" @change='selectDoctor'>
        <el-option v-for="hospital in hospitals" :key="hospital[0]" :value="hospital[0]"></el-option>
      </el-select><br>
      <span>医生：</span>
      <el-select v-model="doctor" class='el-select' :disabled="!hospital || !department" 
      @change="checkAppointment">
        <el-option v-for="doctor in doctors" :key="doctor[0]" :value="doctor[0]" :disabled="noData">
        </el-option>
      </el-select><br>
      <span>日期：</span>
      <el-select v-model="date" class='el-select' :disabled="!doctor" @change='checkValidTime'>
        <el-option v-for="day in days" :key="day" :value="day"></el-option>
      </el-select><br>
      <span>时间：</span>
      <el-select v-model="time" class="el-select" :disabled="!date || leave">
          <el-option v-for="(time,index) in timeList" :key="time" :value="time" 
          :disabled="timeControl[index]"></el-option>
      </el-select><span class="warn">{{leaveMsg}}</span><br>
      <el-button type='primary' @click='submitAppointment'>确认预约</el-button>
      <el-button type="success" class='re-select' @click='reSelect'>重新选择</el-button>
    </div>
  </div>
</template>

<script>
import selfInput from "@/components/selfInput";
import {
  selectHospital,
  selectDoctor,
  selectTime,
  checkValidTime,
  appointment,
  checkAppointment
} from "@/api/custom";
import { looseEqual } from "@/utils";
import { timeList, month, day, hour, minute } from "@/config";
export default {
  components: {
    selfInput
  },
  data() {
    return {
      city: "",
      citys: ["温州", "杭州"],
      hospital: "",
      hospitals: [],
      doctor: "",
      doctors: [],
      date: "",
      days: ["今天", "明天"],
      time: "",
      timeList: [],
      control: 0,
      leave: true,
      leaveMsg: "",
      validTime: "",
      timeControl: [],
      departments: ["骨科", "外科", "内科", "神经科", "皮肤科",'内分泌科'],
      department: "",
      noData: false
    };
  },
  methods: {
    selectHospital() {
      this.hospital = "";
      this.doctor = "";
      this.date = "";
      this.time = "";
      selectHospital({
        city: this.city
      })
        .then(res => {
          // console.log(res.data)
          res.data.forEach((item, index) => {
            if (index === 0) return;
            if (looseEqual(item, res.data[index - 1])) {
              res.data.splice(index, 1);
            }
          });
          this.hospitals = res.data;
        })
        .catch(err => console.log(err));
    },
    selectDoctor() {
      this.doctor = "";
      this.date = "";
      this.time = "";
      selectDoctor({
        hospital: this.hospital,
        department: this.department
      })
        .then(res => {
          if (res.data.length == 0) {
            this.doctors = [["该医院暂时没有该科的医生！"]];
            this.noData = true;
            return;
          }
          this.noData = false;
          res.data.forEach((item, index) => {
            if (index == 0) return;
            if (looseEqual(item, res.data[index - 1])) {
              res.data.splice(index, 1);
            }
          });
          this.doctors = res.data;
        })
        .catch(err => console.log('appointment 118 line: ' + err));
    },
    reSelect() {
      this.city = "";
      this.hospital = "";
      this.doctor = "";
      this.date = "";
      this.time = "";
      this.department = "";
    },
    checkValidTime() {
      this.time = "";
      const date = new Date();
      let day = date.getDate();
      if (this.date == "明天") day++;
      checkValidTime({
        name: this.doctor,
        month,
        day
      })
        .then(res => {
          // console.log(res.data)
          this.FiltertimeList();
          this.timeControl = [];
          if (res.data == "ok") {
            this.leave = false;
            this.leaveMsg = "";
            const loop = this.validTime.length / 21; //一个字符字段21个长度
            for (let i = 0; i < loop; i++) {
              if (
                this.validTime[i * 21] + this.validTime[i * 21 + 1] == month &&
                this.validTime[i * 21 + 2] + this.validTime[i * 21 + 3] == day
              ) {
                let checkTime = "";
                for (let j = 4; j < 15; j++) {
                  checkTime = checkTime + this.validTime[i * 21 + j];
                }
                this.timeList.forEach((item, index) => {
                  if (item == checkTime) {
                    this.$set(
                      this.timeList,
                      index,
                      this.timeList[index] + " 该时段已被预约！"
                    );
                    this.timeControl[index] = true;
                    return;
                  }
                });
              }
            }
          }
          if (res.data == "leave") {
            this.leave = true;
            this.leaveMsg = "医生当天请假，请选择其他医生或者其他时间！";
          }
        })
        .catch(err => console.log(err));
    },
    submitAppointment() {
      const date = new Date();
      let day = date.getDate();
      if (this.date == "明天") day++;
      if (!this.department) {
        alert("未选择科室！");
        return;
      } else if (!this.city) {
        alert("未选择城市！");
        return;
      } else if (!this.hospital) {
        alert("未选择医院！");
        return;
      } else if (!this.doctor) {
        alert("未选择医生！");
        return;
      } else if (!this.date) {
        alert("未选择日期！");
        return;
      } else if (!this.time) {
        alert("未选择时间！");
        return;
      }
      let checkAppointment = confirm("确认要提交吗?");
      if (!checkAppointment) return;
      appointment({
        username: this.$store.state.user.user,
        month,
        day,
        time: this.time,
        doctor: this.doctor
      }).then(res => {
        // console.log(res)
        if (res.data == "ok") {
          alert("预约成功！");
          location.reload();
        }
      });
    },
    checkAppointment() {
      checkAppointment({
        doctor: this.doctor
      })
        .then(res => {
          // console.log(res.data);
          this.validTime = res.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    FiltertimeList() {
      this.timeList = [];
      timeList.forEach(item => {
        this.timeList.push(item);
      });
      if (this.date == "明天") {
        return this.timeList;
      } else if (this.date == "今天") {
        const date = new Date();
        this.timeList.forEach((item, index) => {
          //最迟提前5分钟预约。
          let t = +(String(item[0]) + String(item[1]));
          let test = this.timeList;
          if (t < hour) this.$set(this.timeList, index, 1);
          else if (t == hour && minute >= 26 && item[3] == 0)
            this.$set(this.timeList, index, 1);
          else if (t == hour && minute >= 56 && item[3] == 3)
            this.$set(this.timeList, index, 1);
          else if (t > hour) return;
        });
        this.timeList.forEach(item => {
          if (item == 1) this.control++;
        });
        for (let i = 0; i < this.control; i++) {
          this.timeList.shift();
        }
        this.control = 0;
        return this.timeList;
      }
    }
  },
  // computed: {},
  // mounted() {}
};
</script>

<style scoped lang='scss'>
.appointment {
  width: 80%;
  height: 80vh;
  margin: 20px 0 0 60px;
  padding: 40px;
  border: 1px solid #ddd;
  border-radius: 3px;
  background: #fff;
  box-shadow: 1px 2px 8px #ccc;
}
.el-select {
  margin-bottom: 30px;
}
.re-select {
  position: relative;
  left: 20px;
}
.warn {
  margin-left: 10px;
  color: #f00;
}
</style>
