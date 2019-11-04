import axios from 'axios'
import qs from 'qs'

const request = axios.create({
  timeout: 5000,
  baseURL: 'http://101.200.149.75/api/health/',
  headers: {
    'Content-type': 'application/x-www-form-urlencoded'
  }
})

request.interceptors.request.use(config => {
  console.log(config.method)
  config.data = qs.stringify(config.data)
  return config
}, err => {
  console.log('拦截器请求出错！' + err)
})

export default request
