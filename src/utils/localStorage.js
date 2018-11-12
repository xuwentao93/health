import {TOKEN_KEY} from '@/config'
import {USER} from '@/config'

export const getToken=()=>localStorage.getItem(TOKEN_KEY) //token

export const setToken=token=>localStorage.setItem(TOKEN_KEY,token)

export const removeToken=()=>localStorage.removeItem(TOKEN_KEY)

export const getUser=()=>localStorage.getItem(USER)  //user

export const setUser=user=>localStorage.setItem(USER,user)

export const removeUser=()=>localStorage.removeItem(USER)
