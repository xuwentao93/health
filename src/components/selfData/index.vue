<template>
  <span>
    <input type='text' class='self-data' :value='value' @input="$emit('input', $event.target.value)" 
    @blur="$emit('blur')" @focus="$emit('focus')" @keyup.down='$emit("down")'>
    <slot></slot>
  </span>
</template>

<script>
export default {
  props: ["value"],
  data() {
    return {};
  },

  mounted() {},
  watch: {
    //这个方法用于数字表单校验(两位数)。
    value(newVal, oldVal) {
      if (Object.is(+newVal, NaN) || newVal.length > 2) {
        this.$emit("numberLimit", oldVal);
      }
      const numberExp = /^[1-9][0-9]{0,2}(\.[1-9]?|\s*)$/;
      if (!numberExp.exec(newVal) && newVal!="") {
        this.$emit("priceLimit", oldVal);
      }
    }
  }
};
</script>

<style scoped lang='scss'>
.self-data {
  // position: relative;
  padding-left: 5px;
  width: 90%;
  height: 20px;
  border: transparent;
}
</style>
