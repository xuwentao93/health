import { arrToObj } from "@/utils/arrs";

export const TOKEN_KEY = 'token'

export const USER = 'user'


 const menusConfig = [
    ["selfMsg", "个人信息", false, "all"],
    ["email", "医生注册申请", false, "boss"],
    ["medical", "就诊记录", false, "doctor"],
    ["leave", "请假", false, "doctor"],
    ["cure", "就诊", false, "doctor"],
    ["appointment", "预约挂号", false, "custom"],
    ["sick", "病例记录", false, "custom"],
    ["examination", "体检记录", false, "custom"]
]

export const menus = arrToObj(menusConfig,"url","name","selected","permission")
