<template>
  <div class="email">
    <span class='title'>申请列表</span><hr class='hr'>
    <div v-for='(msg,index) in msgs' :key='msg.username' class='self-msg'>
      <span class='name' @click='toggle(index)'> {{msg.name}} 
        <i class='fa fa-angle-down' :class={rotate:rotate[index]}></i>
      </span>
      <div class="msg" :class={showMsg:rotate[index]}>
        <span>用户名：<span>{{msg.username}}</span></span>
        <span>姓名： <span class='name'>{{msg.name}}</span></span>
        <span>身份证号码： <span class='id'>{{msg.idnumber}}</span></span>
        <span>手机号： <span class='tel'>{{msg.tel}}</span></span>
        <span>就诊医院： <span class='hospital'>{{msg.hospital}}</span></span>
        <span>科室： <span class='department'>{{msg.department}}</span></span>
        <span>医师证明： </span>
        <div><img :src="msg.level" class='prove'></div>
        <div>
          <el-button type='success' @click='addDoctor(msg.username)' class='pass'>通过</el-button>
          <el-button @click='removeDoctor(msg.username)' class='passed'>不通过</el-button>
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
        // await addDoctor({
        //   username
        // })
        // await removeDoctor({
        //   username
        // })
        //   this.showMsg();
        //   alert("操作成功！");
        //   this.$store.state.email.number--;
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
  width: 620px;
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
  color: #f00;
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
  grid-template-columns: 280px 300px;
  grid-template-rows: repeat(3, 40px);
  height: 0;
  font-size:16px;
  overflow: hidden;
  transition: all 0.5s;
  span {
    color: #49f;
  }
  .name {
    color: #67c23a;
  }
  .id {
    color: #e6a23c;
  }
  .tel {
    color: #f56c6c;
  }
  .hospital {
    color: #99a;
  }
  .department {
    color: #fd0;
  }
}
.showMsg {
  height: 650px;
}
.prove {
  position: relative;
  right:190px;
  width: 440px;
  height: 380px;
}
.pass{
  position: relative;
  left:120px;
}
.passed{
  position: relative;
  left:280px;
  z-index:2;
}
</style>
