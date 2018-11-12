<template>
    <div>
      <textarea class='self-textarea' id="" cols="30" rows="10"></textarea>
    </div>
</template>

<script>
import request from "@/utils/request";
const test = () => request.post("test.php");
export default {
  data() {
    return {};
  },
  mounted() {
    const fs = require("fs");
    fs.open(
      Buffer.from("C://Users/user/Desktop/txt/vue.txt"),
      "r",
      (err, fd) => {
        if (err) throw err;
        fs.close(fd, err => {
          if (err) throw err;
        });
      }
    );
  }
};
</script>

<style scoped lang='scss'>
</style>
