<template>
  <el-button-group>
    <el-button @click='moveLast' class='last' :class='{lastFont:lastFont}'>上一页</el-button>
    <el-button v-for='value in buttonLoop' :loading="loading[value-1]" :key='value' 
    @click='changePage(value-1)' :class='{selected:selected[value-1]}'>{{value}}</el-button>
    <el-button @click='moveNext' class='next' :class='{nextFont:nextFont}'>下一页</el-button>
  </el-button-group>
</template>

<script>
export default {
  data() {
    return {
      lastFont: true,
      nextFont: false,
      page: 1,
      selected: [true]
    };
  },
  props: {
    buttonLoop: {
      type: Number,
      default: 1
    },
    loading: {
      type: Array
    }
  },
  methods: {
    moveLast() {
      if (this.page == 1) return; //第一页点击上一页无效
      this.page--;
      this.pageFont();
      this.$emit("moveLast"); //调用父元素方法，接口
      this.selected[this.page - 1] = true;
      this.selected[this.page] = false;
    },
    moveNext() {
      if (this.page == this.buttonLoop) return;
      this.page++;
      this.pageFont();
      this.$emit("moveNext");
      this.selected[this.page - 1] = true;
      this.selected[this.page - 2] = false;
    },
    changePage(value) {
      //按钮切换
      this.page = value + 1;
      this.pageFont();
      this.$emit("changePage", value);
      for (let i = 0; i < this.selected.length; i++) {
        this.selected[i] = false;
      }
      this.selected[value] = true;
    },
    pageFont() {
      //上一页下一页不可点击的时候的样式。
      if (this.buttonLoop == 1) {
        this.lastFont = this.nextFont = true;
        return;
      }
      if (this.page == 1) {
        this.lastFont = true;
        this.nextFont = false;
      } else if (this.page == this.buttonLoop) {
        this.lastFont = false;
        this.nextFont = true;
      } else {
        this.lastFont = false;
        this.nextFont = false;
      }
    }
  }
};
</script>

<style scoped lang='scss'>
.last,
.next {
  border-color: #dcdfd6;
  background: transparent;
  color: #000;
}
.last:hover,
.next:hover {
  border-color: #409eff;
  color: #409eff;
}
.last:active,
.next:active {
  border-color: #00f;
  color: #00f;
}
.selected {
  background: #e9f3fd;
  color: #409eff;
}
.lastFont,
.nextFont {
  color: #c0c4cc;
  border-color: #c0c4cc;
  cursor: not-allowed;
  &:hover{
    border:1px solid #c0c4cc;
    color:#c0c4cc;
  }
}
</style>
