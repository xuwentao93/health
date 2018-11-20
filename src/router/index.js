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
      path: '/forget',
      name: 'forget',
      component: () => import('@/views/forget')
    },
    {
      path: '/main',
      name: 'main',
      component: () => import('@/views/main'),
      children: [
        {
          path: '/main/selfMsg',
          name: 'selfMsg',
          component: () => import('@/views/main/selfMsg')
        },
        {
          path: '/main/email',
          name: 'email',
          component: () => import('@/views/main/boss/email')
        },
        {
          path: '/main/cure',
          name: 'cure',
          component: () => import('@/views/main/doctor/cure')
        },
        {
          path: '/main/leave',
          name: 'leave',
          component: () => import('@/views/main/doctor/leave')
        },
        {
          path: '/main/medical',
          name: 'medical',
          component: () => import('@/views/main/doctor/medical')
        },
        {
          path: '/main/check',
          name: 'check',
          component: () => import('@/views/main/doctor/check')
        },
        {
          path: '/main/examination',
          name: 'examination',
          component: () => import('@/views/main/examinationDoctor')
        },
        {
          path: 'sick',
          name: 'sick',
          component: () => import('@/views/main/custom/sick')
        },
        {
          path: '/main/appointment',
          name: 'appointment',
          component: () => import('@/views/main/custom/appointment')
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
