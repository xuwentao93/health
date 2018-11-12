import axios from 'axios'
import qs from 'qs'

const request = axios.create({
    timeout: 2000,
    headers:{
        "Content-type":"application/json"
    }
    // baseURL:'http://119.23.217.238/dist/saleApi/',
})

request.interceptors.request.use(config => {
    if (config.method == 'post') {
        config.data = qs.stringify(config.data)
    }
    return config
}, err => {
    console.log("拦截器请求出错！" + err)
})

export default request