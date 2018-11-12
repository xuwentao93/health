import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'login',
      component: () => import('@/views/login')
    },
    {
      path: '/regist',
      name: 'regist',
      component: () => import('@/views/regist')
    },
    {
      path: '/main',
      name: 'main',
      component: () => import('@/views/main'),
      children: [
        {
          path: '/main/selfMsg',
          name: 'selfMsg',
          component: () => import('@/components/selfMsg')
        },
        {
          path: '/main/email',
          name: 'email',
          component: () => import('@/components/boss/email')
        },
        {
          path: '/main/cure',
          name: 'cure',
          component: () => import('@/components/doctor/cure')
        },
        {
          path: '/main/leave',
          name: 'leave',
          component: () => import('@/components/doctor/leave')
        },
        {
          path: '/main/medical',
          name: 'medical',
          component: () => import('@/components/doctor/medical')
        },
        {
          path: '/main/examination',
          name: 'examination',
          component: () => import('@/components/custom/examination')
        },
        {
          path: 'sick',
          name: 'sick',
          component: () => import('@/components/custom/sick')
        },
        {
          path: '/main/appointment',
          name: 'appointment',
          component: () => import('@/components/custom/appointment')
        }
      ]
    },
    {
      path: '/doctorRegist',
      name: 'doctorRegist',
      component: () => import('@/views/doctorRegist')
    },
    {
      path: '/test',
      name: 'test',
      component: () => import('@/components/test')
    }
  ]
})
