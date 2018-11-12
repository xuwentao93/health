<template>
  <div class="main">
    <span class="username">患者用户名：</span>
    <self-input style='width:100px;height:24px;margin-bottom:20px;margin-right:20px;' v-model='username'>
    </self-input>
    <el-button type='primary' size='small' @click='checkCustom()'>检查用户</el-button>
    <span v-if='userInfo.name'>姓名：{{userInfo.name}}</span>
    <span v-if='userInfo.idnumber' class='idnumber'>身份证号码：{{userInfo.idnumber}}</span>
    <span v-if='errMsg' class='g-red'>用户不存在！</span>
    <span class='g-red'>{{nameErr}}</span>
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
              :tabindex="100+n*100+index" ref='medicineList' @keyup.enter='selectName(medicine.name,n-1)'
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
import { medicine, cureConclusion, checkCustom } from "@/api/doctor";
import { setTimeout } from "timers";
import { arrToObj } from "@/utils/arrs";
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
      userInfo: {
        name: "",
        idnumber: ""
      },
      errMsg: "",
      nameErr: "",
      illnessErr: "",
      hidden: true
    };
  },
  methods: {
    checkCustom() {
      checkCustom({
        username: this.username
      })
        .then(res => {
          if (res.data == "没有对应的用户名") {
            this.userInfo = "";
            this.errMsg = "没有对应的用户名";
            return;
          }
          this.errMsg = "";
          this.nameErr = "";
          const userInfo = {
            idnumber: res.data[0][0],
            name: res.data[0][1]
          };
          this.userInfo = userInfo;
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
      setTimeout(() => { //用setTimeout 实现下拉框出现失焦
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
      console.log(document.activeElement);
    },
    nextMedicine(n, index) {
      const num = this.$refs.medicineList.length / 10;
      if (index == num - 1) return;
      this.$refs.medicineList[n * num + index + 1].focus();
      console.log(document.activeElement);
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
      document.getElementsByTagName("input")[index*5+1].focus();//让对应的输入框获得焦点。

    },
    cureConclusion() {
      if (!this.userInfo.name) {
        this.nameErr = "请校验用户名是否存在！";
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
        name: this.userInfo.name,
        username: this.username,
        conclusion: this.conclusion,
        illness: this.illness,
        year: date.getFullYear(),
        month: date.getMonth() + 1,
        day: date.getDate() < 10 ? "0" + date.getDate() : date.getDate(),
        hour: date.getHours() < 10 ? "0" + date.getHours() : date.getHours(),
        minute:
          date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes()
      })
        .then(res => {
          alert("提交成功！");
          location.reload();
        })
        .catch(err => console.log(err));
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
.g-red {
  color: red;
}
.username{
  color:#333
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
textarea {
  display: block;
  border-radius: 3px;
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
