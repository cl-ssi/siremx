import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    routes: [

        {
            path: '/login',
            name: 'login',
            component: require('./components/modules/authenticate/login').default
        },

        { path: '/',
          name: 'dashboard.index',
          component: require('./components/modules/dashboard/index').default },

        { path: '/user',
          name: 'user.index',
          component: require('./components/modules/user/index').default },

        { path: '/user/create',
          name: 'create.index',
          component: require('./components/modules/user/create').default },

        { path: '/user/edit/:id',
          name: 'user.edit',
          component: require('./components/modules/user/edit').default,
          props: true },

        { path: '/role',
          name: 'role.index',
          component: require('./components/modules/role/index').default },

        { path: '/role/create',
          name: 'role.create',
          component: require('./components/modules/role/create').default },

        { path: '/role/edit',
            name: 'role.edit',
            component: require('./components/modules/role/edit').default,
            props: true 
        },

        { path: '/permission',
          name: 'permission.index',
          component: require('./components/modules/permission/index').default },

        { path: '/permission/create',
          name: 'permission.create',
          component: require('./components/modules/permission/create').default },

        { path: '/permission/edit',
            name: 'permission.edit',
            component: require('./components/modules/permission/edit').default,
            props: true 
        },

        { path: '/dashboard', component: require('./components/modules/dashboard/index').default },

        { path: '/patient',
          name: 'patient.index',
          component: require('./components/modules/patient/index').default },

        { path: '/patient/create',
          name: 'patient.create',
          component: require('./components/modules/patient/create').default },
        

        { path: '/exam',
          name: 'exam.index',
          component: require('./components/modules/exam/index').default },

        { path: '/exam/create',
          name: 'exam.create',
          component: require('./components/modules/exam/create').default },

        { path: '/exam/view',
            name: 'exam.view',
            component: require('./components/modules/exam/view').default,
            props: true 
        },

        { path: '/examLoad',
          name: 'exam.load',
         component: require('./components/modules/exam/load').default },


        { path: '/report', component: require('./components/modules/report/index').default },
        { path: '/reportMX', component: require('./components/modules/report/mx').default },
        { path: '/reportBirardsAge', component: require('./components/modules/report/birardsAge').default },
        { path: '/patientHistory', component: require('./components/modules/report/patientHistory').default },
        { path: '/reportMXBirards', component: require('./components/modules/report/mxBirards').default },
    ],
    mode: 'history',
    linkActiveClass: 'active'
})