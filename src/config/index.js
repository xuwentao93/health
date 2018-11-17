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

export const menus = arrToObj(menusConfig, "url", "name", "selected", "permission")

export const timeList = ["09:00~9:30", "09:30~10:00", "10:00~10:30", "10:30~11:00", "11:00~11:30",
    "11:30~12:00", "12:00~12:30", "12:30~13:00", "13:00~13:30", "13:30~14:00", "14:00~14:30",
    "14:30~15:00", "15:00~15:30", "15:30~16:00", "16:00~16:30", "16:30~17:00"]

const date = new Date();

export const year = date.getFullYear()
export const month = date.getMonth() + 1
export const day = date.getDate()