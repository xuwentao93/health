import request from '@/utils/request'

export const test = data => request.post('test.php', data)   //各项测试接口