import request from '@/utils/request'

export const selectMsg = data => request.post("selectMsg.php", data)  //查询个人信息的接口