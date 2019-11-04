<!--<template>
  <div class="box" @mouseenter="clear" @mouseleave="move">
    <ul>
      <li v-for="n in 5" :key="n" @mousemove="designate(n)" :class="{checked:checked[n-1]}"></li>
    </ul>
    <img src="./btn-left.png" class="left-btn" @click="last" />
    <img src="./btn-right.png" class="right-btn" @click="next" />
    <div class="carousel" ref="carousel">
      <img v-for="img in imgs" :key="String(img)" :src="img" class="carousel-img" />
    </div>
  </div>
</template>

<script>
import { test } from "@/api/test";
export default {
  data() {
    return {
      imgs: [
        require("./one.jpg"),
        require("./two.jpg"),
        require("./three.jpg"),
        require("./four.jpg"),
        require("./five.jpg")
      ],
      imgsController: 2,
      animated: false,
      testNumber: 10,
      automatic: "",
      checked: [true, false, false, false, false]
    };
  },
  methods: {
    test() {
      test({
        test: this.testNumber
      })
        .then(res => {
          console.log(res.data);
        })
        .catch(err => console.log(err));
    },
    last() {
      if (this.animated) return;
      for (let i = 0; i < 5; i++) {
        this.$set(this.checked, i, false);
      }
      this.$refs.carousel.style.transitionDuration = "1s";
      this.animated = true;
      setTimeout(() => {
        this.animated = false;
      }, 1000);
      let right =
        this.$refs.carousel.style.right == ""
          ? 700
          : parseInt(this.$refs.carousel.style.right);
      this.$set(this.checked, this.imgsController - 3, true);
      this.imgsController--;
      this.$refs.carousel.style.right = right - 700 + "px";
      if (this.imgsController == 1) {
        this.$set(this.checked, 4, true);
        setTimeout(() => {
          this.$refs.carousel.style.transitionDuration = "0s";
          this.$refs.carousel.style.right = 3500 + "px";
          this.imgsController = 6;
        }, 1000);
      }
    },
    next() {
      if (this.animated) return;
      for (let i = 0; i < 5; i++) {
        this.$set(this.checked, i, false);
      }
      this.$refs.carousel.style.transitionDuration = "1s";
      this.animated = true;
      setTimeout(() => {
        this.animated = false;
      }, 900);
      let right =
        this.$refs.carousel.style.right == ""
          ? 700
          : parseInt(this.$refs.carousel.style.right);
      this.$set(this.checked, this.imgsController - 1, true);
      this.imgsController++;
      this.$refs.carousel.style.right = right + 700 + "px";
      if (this.imgsController == 7) {
        this.$set(this.checked, 0, true);
        setTimeout(() => {
          this.$refs.carousel.style.transitionDuration = "0s";
          this.$refs.carousel.style.right = 700 + "px";
          this.imgsController = 2;
        }, 1000);
      }
    },
    move() {
      this.automatic = setInterval(() => {
        this.next();
      }, 2000);
    },
    clear() {
      clearInterval(this.automatic);
    },
    designate(n) {
      this.$refs.carousel.style.transitionDuration = "0s";
      this.imgsController = n + 1;
      this.$refs.carousel.style.right = n * 700 + "px";
      for (let i = 0; i < 5; i++) {
        this.$set(this.checked, i, false);
      }
      this.$set(this.checked, n - 1, true);
    }
  },
  mounted() {
    this.imgs.push(require("./last.jpg"));
    this.imgs.unshift(require("./first.jpg"));
    this.move();
  }
};
</script>

<style scoped lang='scss'>
ul {
  position: absolute;
  bottom: 35px;
  right: 45px;
  z-index: 10;
}
li {
  float: left;
  width: 12px;
  height: 12px;
  margin: 3px;
  background: #000;
  border-radius: 6px;
  cursor: pointer;
}
.checked {
  background: #fff;
}
.box {
  position: relative;
  top: 120px;
  width: 700px;
  height: 400px;
  margin: auto;
  border: 1px solid #eee;
  border-radius: 5px;
  overflow: hidden;
  .left-btn,
  .right-btn {
    position: absolute;
    top: 175px;
    z-index: 2;
    cursor: pointer;
  }
  .left-btn {
    left: 7px;
  }
  .right-btn {
    right: 7px;
  }
  .carousel {
    position: relative;
    right: 700px;
    width: 4900px;
    height: 400px;
    background: #49f;
    transition: all 0.9s;
    .carousel-img {
      display: inline-block;
      width: 700px;
      height: 400px;
    }
  }
}
</style>
-->

<template>
  <div>
    <page-button :buttonLoop='buttonLoop' :loading='loading'></page-button>
    <self-data @input='hello' v-model='test' @blur='fuc'></self-data>
  </div>
</template>

<script>
import pageButton from '@/components/pageButton'
import selfData from '@/components/selfData'
export default {
  components:{
    pageButton,
    selfData
  },
  data(){
    return {
      buttonLoop:3,
      loading:[false,false,false],
      hello:'hello',
      test:'test'
    }
  },
  methods:{
    fuc(){
      console.log(1)
    }
  }
}
</script>

<style scoped>

</style>