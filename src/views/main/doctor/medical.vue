<template>
    <div>
        <div v-for="(medical,index) in medicalList" :key='medical' class='medical'>
            {{index+1}}.<span v-html='medical'></span> <!-- 用v-html才能实现换行 -->
        </div>
        <page-button :buttonLoop="buttonLoop" class='pageButton' @changePage='changePage' 
        @moveLast='moveLast' @moveNext='moveNext' :loading='loading'></page-button>
    </div>
</template>

<script>
import { queryMedical } from "@/api/doctor";
import pageButton from "@/components/pageButton";
export default {
  components: {
    pageButton
  },
  data() {
    return {
      medicalList: [],
      loading: [],
      page: 0,
      buttonLoop: 1
    };
  },
  methods: {
    queryMedical(page) {
      queryMedical({
        doctor: this.$store.state.user.user,
        page
      })
        .then(res => {
          this.buttonLoop = res.data[res.data.length - 1];
          res.data.pop();
          this.medicalList = res.data;
          if (!this.medicalList[1]) this.medicalList.pop();
          this.$set(this.loading, page, false);
        })
        .catch(err => console.log(err));
    },
    changePage(page) {
      this.page = page;
      this.loading[page] = true;
      this.queryMedical(page);
    },
    moveLast() {
      this.queryMedical(--page);
    },
    moveNext() {
      this.queryMedical(++page);
    }
  },
  created() {
    this.queryMedical(0);
  }
};
</script>

<style scoped>
.medical {
  width: 60%;
  margin-bottom: 20px;
  padding: 8px 6px;
  line-height: 30px;
  border: 1px solid #ddd;
  border-radius: 1px;
  background: #fff;
  box-shadow: 1px 2px 8px #ccc;
}
</style>
