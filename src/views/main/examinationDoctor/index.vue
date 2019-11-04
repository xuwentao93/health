<template>
  <div class='out'>
    <div class="examination">
      <span class='username'>请输入病人用户名:</span>
      <self-input v-model='username' @input='closeImg'></self-input>
      <el-button @click='selectChecked' type='primary'>查询检查内容</el-button>
      <span v-if='noCustom' class='g-red'>用户不存在或者没有预约任何检查！</span>
      <span v-if='check'>检查内容：{{check}}</span>
      <div class='prove'>
        <input type="file" ref='img' class='prove-img' @change='checkPhoto'>
        <el-button class='prove-button' @click="handle" type='success'>点击上传检测结果</el-button>
        <img :src="imgsrc" class='choosed-img' v-if='img'>
        <span class="warn img-warn">{{imgErr}}</span>
        <el-button size='mini' type='danger' class='close-img' v-if='img' @click='closeImg'>x</el-button>
      </div>
      <el-button type='success' @click='submitExamination' class='submit'>确认提交</el-button>
    </div>
  </div>
</template>

<script>
import selfInput from "@/components/selfInput";
import { timeList, year, month, day } from "@/config";
import { selectChecked, submitExamination } from "@/api/doctor";
export default {
  components: {
    selfInput
  },
  data() {
    return {
      check: "",
      name: "",
      username: "",
      noCustom: "",
      img: false,
      imgErr: "",
      imgsrc: ""
    };
  },
  methods: {
    selectChecked() {
      selectChecked({
        username: this.username
      })
        .then(res => {
          if (res.data === null) {
            this.noCustom = true;
            this.name = "";
            this.username = "";
          } else {
            this.noCustom = false;
            this.check = res.data;
          }
        })
        .catch(err => console.log(err));
    },
    handle() {
      this.$refs.img.click();
    },
    closeImg() {
      this.img = "";
      this.$refs.img.value = "";
    },
    checkPhoto() {
      //将图片嵌在页面中
      this.img = this.$refs.img.files[0];
      const typeStr = /^(image\/jpg|image\/png|image\/gif|image\/jpeg)$/;
      if (typeStr.exec(this.img.type) == null) {
        this.imgErr = "请上传正确的图片格式！";
        this.img = "";
        return;
      }
      this.imgErr = "";
      let reads = new FileReader();
      reads.onloadend = e => {
        this.imgsrc = e.target.result;
      };
      reads.readAsDataURL(this.img);
    },
    submitExamination() {
      let data = new FormData(); //formdata 可以上传文件
      let username = this.username;
      let checkImg = this.$refs.img.files[0];
      let imgurl = checkImg.name;
      data.append("username", username);
      data.append("check", this.check);
      data.append("checkImg",checkImg);
      data.append("url", imgurl);
      let url =
        "http://101.200.149.75/api/health/submitExamination.php";
      let XHR = new XMLHttpRequest();
      XHR.onreadystatechange = () => {
        if (XHR.readyState == 4 && XHR.status == 200) {
          if(XHR.responseText !== "success") return
          alert("检查提交成功！");
          location.reload();
        }
      };
      XHR.open("POST", url);
      XHR.send(data);
    }
  },
  mounted() {}
};
</script>

<style scoped lang='scss'>
.g-red {
  color: #f00;
}
.el-select {
  margin: 0 20px 20px 0;
}
.el-button {
  z-index: 2;
}
.out {
  background: #f1f1f1;
}
.examination {
  width: 80%;
  height: 80vh;
  margin: 20px 0 0 60px;
  padding: 40px;
  border: 1px solid #ddd;
  border-radius: 3px;
  background: #fff;
  box-shadow: 1px 2px 8px #ccc;
  .self-input {
    width: 200px;
    margin: 0 20px 0 5px;
  }
}
.username{
  margin-left:200px;
}
.prove {
  position: relative;
  top: 50px;
  left: 26%;
  width: 300px;
  height: 300px;
  text-align: center;
  border: 1px dotted #000;
  text-align: center;
  .prove-img {
    display: none;
  }
  .prove-button {
    position: relative;
    top: 110px;
  }
  .choosed-img {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 3;
    width: 100%;
    height: 100%;
  }
  .img-warn {
    top: 277px;
  }
  .close-img {
    position: absolute;
    z-index: 4;
    top: 0;
    right: 0;
  }
}
.submit{
  position: relative;
  top:100px;
  left:40%;
}
</style>
