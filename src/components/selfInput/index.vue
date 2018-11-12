<template>
  <input type="text" class='self-input' @change='change' @keyup.enter='enter' :value='value' 
  @input="$emit('input', $event.target.value)">
</template>

<script>
export default {
  props: ['value',"width"],
  methods:{
    enter(){
      this.$emit('enter');
    },
    change(){
      this.$emit('change');
    }
  }
};
</script>

<style scoped lang='scss'>
.self-input {
  display: inline-block;
  width: 95%;
  height: 28px;
  padding: 6px 8px;
  border: 1px solid rgb(209, 213, 218);
  border-radius: 3px;
  background: #fafbfc;
  font-family: -apple-system;
  &:focus {
    border-color: #2188ff;
    box-shadow: inset 0 1px 2px rgba(27, 31, 35, 0.075),
      0 0 0 0.2em rgba(3, 102, 214, 0.3);
    background: #fff;
  }
  transition: all .2s linear;
}
</style>
