import request from '@/utils/request'

export const login = data => request.post("login.php", data) //登录

export const identifying = data => request.post('mobiletest/smsyzm.php', data) //手机验证码

export const checkUser = data => request.post('checkUser.php', data) //验证用户名是否已经存在

export const checkTel = data => request.post('checkTel.php', data) //验证手机号是否已经存在

export const regist = data => request.post('regist.php', data) // 注册接口，添加用户名，密码和权限

export const registMsg = data => request.post('registMsg.php', data) //第二个注册接口，用于往用户信息表添加信息

export const doctorRegist = data => request.post('doctorRegist.php', data) //医生注册

export const checkHospital = () => request.post('checkHospital.php') //选择医院