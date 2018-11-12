<template>
  <div>
    <div class="appointment">
      <span>地区：</span>
      <el-select v-model="city" class='city' @change="selectHospital">
       <el-option v-for='city in citys' :key='city' :value="city"></el-option>
      </el-select><br>
      <span>医院：</span>
      <el-select v-model="hospital" class='hospital' :disabled="boolRegion" @change='selectDoctor'>
        <el-option v-for="hospital in hospitals" :key="hospital[0]" :value="hospital[0]"></el-option>
      </el-select><br>
      <span>医生：</span>
      <el-select v-model="doctor" class='doctor' :disabled="boolHospital">
        <el-option v-for="doctor in doctors" :key="doctor[0]" :value="doctor[0]"></el-option>
      </el-select><br>
      <span>日期：</span>
      <el-select v-model="date" class='date' :disabled="boolDoctor">
        <el-option v-for="day in days" :key="day" :value="day"></el-option>
      </el-select><br>
      <span>时间：</span>
      <el-select v-model="time" class="time" :disabled="boolDate">
          <el-option>123</el-option>
      </el-select>
    </div>
  </div>
</template>

<script>
import selfInput from "@/components/selfInput";
import { selectHospital, selectDoctor, selectTime } from "@/api/custom";
import { looseEqual } from "@/utils";
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
      times: []
    };
  },
  methods: {
    test() {
      console.log(1);
    },
    selectHospital() {
      selectHospital({
        city: this.city
      })
        .then(res => {
          res.data.forEach((item, index) => {
            if (index == 0) return;
            if (looseEqual(item, res.data[index - 1])) {
              res.data.splice(index, 1);
            }
          });
          this.hospitals = res.data;
        })
        .catch(err => console.log(err));
    },
    selectDoctor() {
      selectDoctor({
        hospital: this.hospital
      })
        .then(res => {
          res.data.forEach((item, index) => {
            if (index == 0) return;
            if (looseEqual(item, res.data[index - 1])) {
              res.data.splice(index, 1);
            }
          });
          this.doctors = res.data;
        })
        .catch(err => console.log(err));
    }
  },
  computed: {
    boolRegion() {
      //el-select的参数要求必须是布尔。
      return this.city ? false : true;
    },
    boolHospital() {
      return this.hospital ? false : true;
    },
    boolDoctor() {
      return this.doctor ? false : true;
    },
    boolDate() {
      return this.date ? false : true;
    }
  }
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
.city,
.hospital,
.doctor,
.date {
  margin-bottom: 30px;
}
</style>
