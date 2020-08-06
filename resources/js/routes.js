import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    routes: [
        { path: '/', component: require('./components/modules/dashboard/index').default },

        { path: '/user', component: require('./components/modules/user/index').default },
        { path: '/user/create', component: require('./components/modules/user/create').default },

        { path: '/role', component: require('./components/modules/role/index').default },
        { path: '/role/create', component: require('./components/modules/role/create').default },
        { path: '/role/edit',
            name: 'role.edit',
            component: require('./components/modules/role/edit').default,
            props: true 
        },


        { path: '/report', component: require('./components/modules/report/index').default },
        { path: '/permission', component: require('./components/modules/permission/index').default },
        { path: '/dashboard', component: require('./components/modules/dashboard/index').default },

        { path: '/patient', component: require('./components/modules/patient/index').default },
        { path: '/patient/create', component: require('./components/modules/patient/create').default },
        

        { path: '/exam', component: require('./components/modules/exam/index').default },
        { path: '/exam/create', component: require('./components/modules/exam/create').default },
        { path: '/exam/view',
            name: 'exam.view',
            component: require('./components/modules/exam/view').default,
            props: true 
        },
        { path: '/examLoad', component: require('./components/modules/exam/load').default },
    ],
    mode: 'history',
    linkActiveClass: 'active'
})