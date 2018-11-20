import request from '@/utils/request'

export const showMsg = () => request.post('showMsg.php') // 查询医生信息是否正确。

export const addDoctor = data => request.post('addDoctor.php', data) // 医生确认属实并且同意添加
// export async function addDoctor(data) {
//     return request.post('addDoctor.php', data)
// }

export const removeDoctor = data => request.post('removeDoctor.php', data) // 拒绝医生请求

// export async function removeDoctor(data){
//     return request.post("removeDoctor.php", data)
// }
