<template>
  <div class="forget">
    <span>用户名：</span><self-input style="width:80%"></self-input>
    <span>密码：</span><self-input style="width:80%"></self-input>
    <span>手机号：</span><self-input style="width:80%"></self-input>
    <self-input style='width:40%'></self-input>
    <el-button>发送手机验证码</el-button>
    <span>确认密码：</span><self-input style="width:80%"></self-input>
    <el-button type='primary'>确认修改</el-button>
    <el-button>返回首页</el-button>
  </div>
</template>

<script>
import selfInput from "@/components/selfInput";
export default {
    components:{
        selfInput
    },
}
</script>

<style scoped>
.forget{
    position: relative;
    top:200px;
    left:30%;
    width:30%;
    height:400px;
}
</style>
