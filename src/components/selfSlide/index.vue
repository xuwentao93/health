<template>
    <div class='slide' ref='slide'>
      <div class="cube" @mousedown="move" tabindex="111" ref='cube'>
        
          <hr class='self-arrow' ref='arrow'>
          <div class='self-angel' ref='angel'></div>
          <i class="fa fa-check" v-if='!slideController'></i>
      
      </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      slideController: true
    }
  },
  methods: {
    move(e) {
      if (this.slideController == false) return; // 滑块到底部事件跳出
      let startX = e.clientX // 触发事件的时候鼠标的X轴位置。
      let slide = this.$refs.slide
      let cube = this.$refs.cube
      let startLeft = cube.style.left == '' ? -1 : parseFloat(cube.style.left);
      let max = slide.offsetWidth - cube.offsetWidth + 1 //padding + border + width = offsetWidth
      document.onmousemove = e => {
        // document效果会更好
        if (cube.style.left == max + 'px') {
          cube.style.backgroundColor = '#52ccba'
          cube.style.cursor = 'not-allowed'
          this.$refs.arrow.style.borderColor = 'transparent'
          this.$refs.angel.style.borderColor = 'transparent'
          this.slideController = false
          return
        }
        let left = Math.min(max,Math.max(-1, startLeft + (e.clientX - startX)))// 防止左右划出边界
        cube.style.left = left + "px"

        window.getSelection().removeAllRanges()
        document.onmouseup = () => {
          document.onmousemove = null
        }
      }
    }
  }
}
</script>

<style scoped lang='scss'>
.slide {
  position: relative;
  width: 330px;
  height: 40px;
  border: 1px solid #e4e7eb;
  border-radius: 2px;
  background: rgb(247, 249, 250);
  .cube {
    position: relative;
    left: -1px;
    top: -1px;
    width: 40px;
    height: 40px;
    border: 1px solid #e4e7eb;
    border-radius: 3px;
    text-align: center;
    line-height: 45px;
    background: #fff;
    outline: none;
    transition: background-color 0.2s linear;
    cursor: pointer;
    &:hover {
      background: #1991fa;
      .self-arrow,
      .self-angel {
        border-color: #fff;
      }
    }
    &:focus {
      background: #1991fa;
      .self-arrow,
      .self-angel {
        border-color: #fff;
      }
    }
  }
}
.self-arrow {
  position: relative;
  right: 1px;
  display: inline-block;
  height: 0;
  width: 15px;
  border: 0px;
  border-top: 2.5px solid rgb(114, 120, 125);
}
.self-angel {
  position: relative;
  left: 17px;
  top: -30px;
  bottom: 0.5px;
  width: 9px;
  height: 9px;
  border-top: 2px solid rgb(114, 120, 125);
  border-right: 2px solid rgb(114, 120, 125);
  border-radius: 2px;
  transform: rotate(45deg);
}
.fa-check {
  position: relative;
  top: -58px;
  color: #fff;
}
</style>
