<template>
  <div class="main">
    <span>选择时间段：</span>
    <el-select v-model="time" @change='reserved'>
    <el-option v-for="time in timeList" :key='time' :value='time'></el-option>
    </el-select>
    <span v-if='username'>用户名：{{username}}</span>
    <span v-if='name'>姓名：{{name}}</span>
    <span v-if='noCustom' class='g-red'>该时间段还没有病人预约！</span>
    <!-- <span class='g-red'>{{nameErr}}</span> -->
    <el-button class='hasCheck' @click='showCheck' type='primary' v-if='hasCheck' size="medium">
      点击查看检查结果
    </el-button>
    <div class="examination" ref='examination' v-if='showExamination'>
      <img :src="examinationSrc" class='examination-img'>
      <el-button @click='closeExamination' type='danger' size='mini' class='close'>
        X
      </el-button>
    </div>
    <textarea cols="60" rows="10" placeholder="病人病情" v-model='illness' ref="textarea"></textarea>
    <span class='illnessErr'>{{illnessErr}}</span>
    <table>
      <tr class='title'>
        <td>药名</td>
        <td>用量</td>
        <td>次数</td>
        <td>数量(最大99)</td>
        <td>单价</td>
        <td>总价</td>
      </tr>
      <tr v-for='n in 10' :key='n'>
        <td>
          <!-- 药名标签，失去聚焦下拉框消失，打字的时候出现，按↓的时候进入下拉框 -->
          <self-data v-model='conclusion[n-1].name' @input='medicine(conclusion[n-1].name,n-1)' 
          class='medicine-name' @blur='close(n-1)' @down="toggleMedicineList(n-1)">
          <!-- 下拉框，按↓和↑可以选择药名，点击和按回车选中药 -->
            <div class='medicine-list' v-show='medicines.length >0 && conclusion[n-1].name' 
              ref='medicine'>
              <div v-for='(medicine,index) in medicines' @keyup.down="nextMedicine(n-1,index)" 
              @keyup.up='lastMedicine(n-1,index)' :key='medicine.name' @click='selectName(medicine.name,n-1)' 
              :tabindex="100 + n * 100 + index" ref='medicineList' @keyup.enter='selectName(medicine.name,n-1)'
               @blur='close2(n-1)'>
              {{medicine.name}}</div>
            </div>
          </self-data>
        </td>
        <td><self-data v-model='conclusion[n-1].dosage'></self-data></td>
        <td><self-data v-model='conclusion[n-1].time'></self-data></td>
        <td>
          <self-data v-model='conclusion[n-1].number' @numberLimit="numberLimit($event,n-1)" @input='sum(n-1)'>
          </self-data></td>
        <td><self-data v-model='conclusion[n-1].price' @priceLimit='priceLimit($event,n-1)' 
        @input="sum(n-1)"></self-data></td>
        <td class='mount'><span v-show='conclusion[n-1].mount'>￥</span>{{conclusion[n-1].mount}}</td>
      </tr>
    </table>
    <el-button type='success' @click='cureConclusion'>确认</el-button>
  </div>
</template>

<script>
import selfData from "@/components/selfData";
import selfInput from "@/components/selfInput";
import { medicine, cureConclusion, reserved, ifChecked } from "@/api/doctor";
import { setTimeout } from "timers";
import { arrToObj } from "@/utils/arrs";
import { looseEqual} from "@/utils"
import { timeList, year, month, day } from "@/config";
export default {
  components: {
    selfData,
    selfInput
  },
  data() {
    return {
      username: "",
      medicines: [],
      conclusion: [],
      illness: "",
      name: "",
      noCustom: false,
      nameErr: "",
      illnessErr: "",
      hidden: true,
      time: "",
      timeList,
      showExamination: false,
      hasCheck: false,
      examinationSrc: ""
    };
  },
  methods: {
    reserved() {
      reserved({
        doctor: this.$store.state.user.user,
        time: this.time,
        month,
        day
      })
        .then(res => {
          if (res.data === "none") {
            console.log(1)
            this.noCustom = true;
            this.name = "";
            this.username = "";
          } else {
            this.noCustom = false;
            this.username = res.data[0];
            this.name = res.data[1];
            ifChecked({
              username: this.username
            })
              .then(res => {
                console.log(res.data)
                if (looseEqual(res.data,[null,null])) {
                  this.hasCheck = false;
                  return;
                }
                this.hasCheck = true;
                this.examinationSrc = `http://101.200.149.75/api/health/examination/${
                  res.data[0]
                }`;
              })
              .catch(err => console.log(err));
          }
        })
        .catch(err => console.log(err));
    },
    numberLimit(oldVal, index) {
      //数量检测
      this.$set(this.conclusion[index], "number", oldVal);
    },
    priceLimit(oldVal, index) {
      //价格检测
      this.$set(this.conclusion[index], "price", oldVal);
    },
    sum(index) {
      //价格统计
      if (!this.conclusion[index].number || !this.conclusion[index.price]) {
        this.$set(this.conclusion[index], "mount", "");
      }
      if (this.conclusion[index].number && this.conclusion[index].price) {
        let t = +this.conclusion[index].number * +this.conclusion[index].price;
        this.$set(this.conclusion[index], "mount", t);
      }
    },
    close(index) {
      //失去焦点的时候关闭搜索栏，150毫秒的延迟让其能够执行药名选择。
      setTimeout(() => {
        if (!this.hidden) return;
        this.medicines = [];
        this.$refs.medicine[index].style.display = "none";
      }, 150);
    },
    close2(n) {
      const medicineList = this.$refs.medicineList;
      const num = medicineList.length / 10;
      setTimeout(() => {
        //用setTimeout 实现下拉框出现失焦
        for (let i = num * n; i < num * n + num; i++) {
          if (document.activeElement.tagName == "DIV") return;
          else {
            this.hidden = true;
            this.close(n);
          }
        }
      }, 100);
    },
    medicine(value, index) {
      if (!value) {
        this.medicines = [];
        return;
      }
      medicine({
        medicine: value
      })
        .then(res => {
          this.$refs.medicine[index].style.display = "block";
          if (res.data == "没有相关的药品" || res.data == 22) {
            const obj = {
              name: "没有相关的药品"
            };
            //this.medicines[0] = obj;
            this.$set(this.medicines, 0, obj);
            return;
          }
          arrToObj(res.data, "name");
          this.medicines = res.data;
        })
        .catch(err => console.log(err));
    },
    toggleMedicineList(index) {
      //输入框进入下拉框
      if (!this.conclusion[index].name) return;
      this.hidden = false;
      const num = this.$refs.medicineList.length / 10;
      this.$refs.medicineList[index * num].focus();
    },
    nextMedicine(n, index) {
      const num = this.$refs.medicineList.length / 10;
      if (index == num - 1) return;
      this.$refs.medicineList[n * num + index + 1].focus();
    },
    lastMedicine(n, index) {
      const num = this.$refs.medicineList.length / 10;
      if (index == 0) return;
      this.$refs.medicineList[n * num + index - 1].focus();
    },
    selectName(name, index) {
      if (name == "没有相关的药品") return;
      this.conclusion[index].name = name;
      this.hidden = true;
      this.medicines = [];
      document.getElementsByTagName("input")[index * 5 + 1].focus(); //让对应的输入框获得焦点。
    },
    cureConclusion() {
      if (!this.name) {
        this.nameErr = "请选择病人！";
        return;
      } else {
        this.nameErr = "";
        this.errMsg = "";
      }
      if (!this.illness) {
        this.illnessErr = "请填写病人病情！";
        return;
      } else this.illnessErr = "";
      if (this.illnessErr || this.nameErr) return;
      let check = confirm("确认要提交吗？");
      if (!check) return;
      const date = new Date();
      cureConclusion({
        doctor: this.$store.state.user.user,
        name: this.name,
        username: this.username,
        conclusion: this.conclusion,
        illness: this.illness,
        year,
        month,
        day: day < 10 ? "0" + day : day,
        hour: date.getHours() < 10 ? "0" + date.getHours() : date.getHours(),
        minute:
          date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes()
      })
        .then(res => {
          console.log(res.data);
          alert("提交成功！");
          location.reload();
        })
        .catch(err => console.log(err));
    },
    showCheck() {
      this.showExamination = true;
      // this.$refs.examination.style.opacity = "1 !important";
    },
    closeExamination(){
      this.showExamination = false;
      this.$store.state.bg.bg = false;
    }
  },
  created() {
    for (let i = 0; i < 10; i++) {
      const obj = {
        name: "",
        dosage: "",
        time: "",
        number: "",
        price: "",
        mount: ""
      };
      this.conclusion.push(obj); //conclusion有值才能循环，否则vue会报错undefined。
    }
  }
};
</script>

<style scoped lang='scss'>
div {
  outline: none;
}
.el-select {
  margin: 0 20px 20px 0;
}
.g-red {
  color: red;
}
.main {
  background: #fff !important;
}
.username {
  color: #333;
}
.title td {
  text-align: center;
}
.test {
  border-color: transparent;
}
.idnumber {
  position: relative;
  left: 15px;
}
.examination {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 500px;
  height: 500px;
  margin-left: -250px;
  margin-top: -250px;
  z-index: 10;
  opacity: 1;
  .examination-img{
    width:500px;
    height:500px;
  }
  .close{
    position: absolute;
    right:0;
    top:0;
  }
}
textarea {
  display: block;
  border-radius: 3px;
  border:1px solid #dcdfe6
}
.illnessErr {
  display: block;
  margin-bottom: 20px;
  color: red;
}
table {
  margin-bottom: 20px;
  background: #fff;
}
td {
  position: relative;
  height: 24px;
  border: 1px solid #dcdfe6;
}
th:first-child {
  width: 16vw;
  min-width: 240px;
}
.medicine-list {
  position: absolute;
  top: 24px;
  left: 0;
  z-index: 2;
  display: none;
  width: 100%;
  max-height: 150px;
  overflow: auto;
  border: 1px solid #909399;
  border-radius: 2px;
  div {
    position: relative;
    height: 30px;
    line-height: 30px;
    background: #fff;
    cursor: pointer;
    &:hover,
    &:focus {
      background: #dcdfe6;
    }
  }
}
.mount {
  width: 150px;
}
</style>
