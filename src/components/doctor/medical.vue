<template>
    <div>
        <div v-for="(medical,index) in medicalList" :key='medical' class='medical'>
            {{index+1}}.<span v-html='medical'></span> <!-- 用v-html才能实现换行 -->
        </div>
    </div>
</template>

<script>
import { queryMedical } from "@/api/doctor";
export default {
  data() {
    return {
      medicalList: []
    };
  },
  methods: {
    test(){
      this.queryMedical();
    },
    queryMedical() {
      queryMedical({
        doctor: this.$store.state.user.user
      })
        .then(res => {
          this.medicalList = res.data
        })
        .catch(err => console.log(err));
    }
  },
  mounted(){
    this.queryMedical()
  }
};
</script>

<style scoped>
.medical{
  width:60%;
  margin-bottom:20px;
  padding:8px 6px;
  line-height: 30px;
  border:1px solid #ddd;
  border-radius: 1px;
  background: #fff;
  box-shadow: 1px 2px 8px #ccc;

}
</style>
