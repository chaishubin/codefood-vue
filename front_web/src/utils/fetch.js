import axios from 'axios'
import { Message } from 'element-ui'
// import store from '../store'
// import { getToken,setToken } from '@/utils/auth'
//import { loginToken } from "@/api/login";

// 创建axios实例
const service = axios.create({
  baseURL: process.env.BASE_API, // api的base_url
  timeout: 150000,                  // 请求超时时间
  withCredentials: false,
})


export default service
