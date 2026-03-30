import { createRouter, createWebHistory } from 'vue-router';

// Layouts
import AppLayout from './components/App.vue';
import AuthLayout from './components/Auth.vue';
import MainLayout from './components/MainLayout.vue';

// Lazy load (mejor performance)
const Login = () => import('./components/modules/authenticate/login.vue');
const Logout = () => import('./components/modules/authenticate/logout.vue');
const LoginCU = () => import('./components/modules/authenticate/logincu.vue');

const Dashboard = () => import('./components/modules/dashboard/index.vue');
const DashAudit = () => import('./components/modules/dashboard/dashAudit.vue');

const UserIndex = () => import('./components/modules/user/index.vue');
const UserCreate = () => import('./components/modules/user/create.vue');
const UserEdit = () => import('./components/modules/user/edit.vue');
const UserPermission = () => import('./components/modules/user/permission.vue');

const RoleIndex = () => import('./components/modules/role/index.vue');
const RoleCreate = () => import('./components/modules/role/create.vue');
const RoleEdit = () => import('./components/modules/role/edit.vue');

const PermissionIndex = () => import('./components/modules/permission/index.vue');
const PermissionCreate = () => import('./components/modules/permission/create.vue');
const PermissionEdit = () => import('./components/modules/permission/edit.vue');

const PatientIndex = () => import('./components/modules/patient/index.vue');
const PatientCreate = () => import('./components/modules/patient/create.vue');
const PatientEdit = () => import('./components/modules/patient/edit.vue');

const ExamIndex = () => import('./components/modules/exam/index.vue');
const ExamCreate = () => import('./components/modules/exam/create.vue');
const ExamEdit = () => import('./components/modules/exam/edit.vue');
const ExamView = () => import('./components/modules/exam/view.vue');
const ExamLoad = () => import('./components/modules/exam/load.vue');
const ExamLoadHistory = () => import('./components/modules/exam/loadHistory.vue');

const ReportIndex = () => import('./components/modules/report/index.vue');
const ReportMX = () => import('./components/modules/report/mx.vue');
const ReportSigte = () => import('./components/modules/report/mxSigte.vue');
const ReportBirardsAge = () => import('./components/modules/report/birardsAge.vue');
const PatientHistoryClinical = () => import('./components/modules/report/patientHistoryClinical.vue');
const PatientHistory = () => import('./components/modules/report/patientHistory.vue');
const ReportMXBirards = () => import('./components/modules/report/mxBirards.vue');
const ReportMXBiradYears = () => import('./components/modules/report/mxBiradYear.vue');
const ReportMXCoverage = () => import('./components/modules/report/mxCoverage.vue');

const NotFound = () => import('./components/layouts/404.vue');

// 🔐 Guard
function verifyAccess(to, from, next) {
    let authUser = JSON.parse(localStorage.getItem("authUser"));

    if (authUser) {
        let listRolePermissionsByUser = JSON.parse(
            localStorage.getItem("listRolePermissionsByUser")
        ) || [];

        if (listRolePermissionsByUser.includes(to.name)) {
            next();
        } else {
            let fallback = listRolePermissionsByUser.find(x => x && x.includes("index"));
            if (to.name === "dashboard.index" && fallback) {
                next({ name: fallback });
            } else {
                next(from.fullPath || '/');
            }
        }
    } else {
        next('/auth/login');
    }
}

const routes = [
    // 🔐 AUTH
    {
        path: '/auth',
        component: AuthLayout,
        children: [
            { path: 'login', name: 'login', component: Login },
            { path: 'logout', name: 'logout', component: Logout },
            { path: 'logincu/:token', name: 'logincu', component: LoginCU, props: true }
        ]
    },

    // 🧩 APP (PROTEGIDO)
    {
        path: '/',
        component: MainLayout,
        beforeEnter: verifyAccess,
        children: [
            { path: '', name: 'dashboard.index', component: Dashboard },
            { path: 'dashboard', component: Dashboard },

            { path: 'dashboardAudit', name: 'dashboardAudit.index', component: DashAudit },

            { path: 'user', name: 'user.index', component: UserIndex },
            { path: 'user/create', name: 'user.create', component: UserCreate },
            { path: 'user/edit/:id', name: 'user.edit', component: UserEdit, props: true },
            { path: 'user/permission/:id', name: 'user.permission', component: UserPermission, props: true },

            { path: 'role', name: 'role.index', component: RoleIndex },
            { path: 'role/create', name: 'role.create', component: RoleCreate },
            { path: 'role/edit/:id', name: 'role.edit', component: RoleEdit, props: true },

            { path: 'permission', name: 'permission.index', component: PermissionIndex },
            { path: 'permission/create', name: 'permission.create', component: PermissionCreate },
            { path: 'permission/edit/:id', name: 'permission.edit', component: PermissionEdit, props: true },

            { path: 'patient', name: 'patient.index', component: PatientIndex },
            { path: 'patient/create', name: 'patient.create', component: PatientCreate },
            { path: 'patient/edit/:id', name: 'patient.edit', component: PatientEdit, props: true },

            { path: 'exam', name: 'exam.index', component: ExamIndex },
            { path: 'examCreate', name: 'exam.create', component: ExamCreate },
            { path: 'exam/edit/:id', name: 'exam.edit', component: ExamEdit, props: true },
            { path: 'exam/view/:id', name: 'exam.view', component: ExamView, props: true },
            { path: 'examLoad', name: 'exam.load', component: ExamLoad },
            { path: 'examLoadHistory', name: 'examLoadHistory.load', component: ExamLoadHistory },

            { path: 'report', name: 'report.index', component: ReportIndex },
            { path: 'reportMX', name: 'reportMX.index', component: ReportMX },
            { path: 'reportSigte', name: 'reportSigte.index', component: ReportSigte },
            { path: 'reportBirardsAge', name: 'reportBirardsAge.index', component: ReportBirardsAge },
            { path: 'patientHistoryClinical', name: 'patientHistoryClinical.index', component: PatientHistoryClinical },
            { path: 'patientHistory', name: 'patientHistory.index', component: PatientHistory },
            { path: 'reportMXBirards', name: 'reportMXBirards.index', component: ReportMXBirards },
            { path: 'reportMXBiradYears', name: 'reportMXBiradYears.index', component: ReportMXBiradYears },
            { path: 'reportMXcoverage', name: 'reportMXcoverage.index', component: ReportMXCoverage },
        ]
    },

    // ❌ 404
    {
        path: '/:pathMatch(.*)*',
        component: NotFound
    }
];

const router = createRouter({
    history: createWebHistory('/siremx/'),
    linkActiveClass: 'active',
    routes
});

export default router;