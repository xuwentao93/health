<template>
    <div>
        <div v-for="(medical,index) in medicalList" :key='medical[0]' class='sick'>
            {{index+1}}.<span v-html='medical'></span> <!-- 用v-html才能实现换行 -->
        </div>
    </div>
</template>

<script>
import { querySick } from "@/api/custom";
export default {
  data() {
    return {
      medicalList: []
    };
  },
  methods: {
    test(){
      this.querySick();
    },
    querySick() {
      querySick({
        custom: this.$store.state.user.user
      })
        .then(res => {
          this.medicalList = res.data
        })
        .catch(err => console.log(err));
    }
  },
  mounted(){
    this.querySick()
  }
};
</script>

<style scoped>
.sick{
  width:60%;
  margin-bottom:20px;
  padding:8px 6px;
  border:1px solid #ddd;
  border-radius: 1px;
  line-height: 30px;
  background: #fff;
  box-shadow: 1px 2px 8px #ccc
}
</style>
