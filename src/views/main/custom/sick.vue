<template>
    <div>
        <div v-for="(medical,index) in medicalList" :key='medical' class='sick'>
            {{index+1}}.<span v-html='medical'></span> <!-- 用v-html才能实现换行 -->
        </div>
        <page-button :buttonLoop="buttonLoop" class='pageButton' @changePage='changePage' 
        @moveLast='moveLast' @moveNext='moveNext' :loading='loading'></page-button>
    </div>
</template>

<script>
import { querySick } from "@/api/custom";
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
    querySick(page) {
      querySick({
        custom: this.$store.state.user.user,
        page
      })
        .then(res => {
          //this.medicalList = res.data;
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
      this.querySick(page);
    },
    moveLast() {
      this.querySick(--this.page);
    },
    moveNext() {
      this.querySick(++this.page);
    }
  },
  created() {
    this.querySick(0);
  }
};
</script>

<style scoped>
.sick {
  width: 60%;
  margin-bottom: 20px;
  padding: 8px 6px;
  border: 1px solid #ddd;
  border-radius: 1px;
  line-height: 30px;
  background: #fff;
  box-shadow: 1px 2px 8px #ccc;
}
</style>
