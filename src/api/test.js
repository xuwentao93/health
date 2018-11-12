import request from '@/utils/testReq'

export const nodeTest = ()=>request.post("https://open.ucpaas.com/ol/sms/sendsms");