import { createRouter, createWebHistory } from 'vue-router';

function verifyAccess(to, from, next) {
    let authUser = JSON.parse(localStorage.getItem("authUser"));
    if (authUser) {
        let listRolePermissionsByUser = JSON.parse(
            localStorage.getItem("listRolePermissionsByUser")
        ) || [];
        if (listRolePermissionsByUser.includes(to.name)) {
            next();
        } else {
            let listRolePermissionsByUserFilter = listRolePermissionsByUser.filter(
                x => x && x.includes("index") // ← filter en vez de map + push
            );
            if (to.name == "dashboard.index") {
                next({ name: listRolePermissionsByUserFilter[0] });
            } else {
                next(from.path);
            }
        }
    } else {
        next("/login");
    }
}

const router = createRouter({
    history: createWebHistory('/siremx/'),
    linkActiveClass: "active",
    routes: [
        {
            path: "/login",
            name: "login",
            component: require("./components/modules/authenticate/login").default
        },
        {
            path: "/logout",
            name: "logout",
            component: require("./components/modules/authenticate/logout").default
        },
        {
            path: "/logincu/:token",
            name: "logincu",
            component: require("./components/modules/authenticate/logincu").default
        },
        {
            path: "/",                               // ← una sola ruta "/"
            name: "dashboard.index",
            component: require("./components/modules/dashboard/index").default,
            beforeEnter: verifyAccess               // verifyAccess redirige a /login si no hay auth
        },
        {
            path: "/dashboardAudit",
            name: "dashboardAudit.index",
            component: require("./components/modules/dashboard/dashAudit").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/user",
            name: "user.index",
            component: require("./components/modules/user/index").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/user/create",
            name: "user.create",
            component: require("./components/modules/user/create").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/user/edit/:id",
            name: "user.edit",
            component: require("./components/modules/user/edit").default,
            beforeEnter: verifyAccess,
            props: true
        },
        {
            path: "/user/permission/:id",
            name: "user.permission",
            component: require("./components/modules/user/permission").default,
            beforeEnter: verifyAccess,
            props: true
        },
        {
            path: "/role",
            name: "role.index",
            component: require("./components/modules/role/index").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/role/create",
            name: "role.create",
            component: require("./components/modules/role/create").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/role/edit/:id",
            name: "role.edit",
            component: require("./components/modules/role/edit").default,
            beforeEnter: verifyAccess,
            props: true
        },
        {
            path: "/permission",
            name: "permission.index",
            component: require("./components/modules/permission/index").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/permission/create",
            name: "permission.create",
            component: require("./components/modules/permission/create").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/permission/edit/:id",
            name: "permission.edit",
            component: require("./components/modules/permission/edit").default,
            beforeEnter: verifyAccess,
            props: true
        },
        {
            path: "/dashboard",
            component: require("./components/modules/dashboard/index").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/patient",
            name: "patient.index",
            component: require("./components/modules/patient/index").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/patient/edit/:id",
            name: "patient.edit",
            component: require("./components/modules/patient/edit").default,
            beforeEnter: verifyAccess,
            props: true
        },
        {
            path: "/patient/create",
            name: "patient.create",
            component: require("./components/modules/patient/create").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/exam",
            name: "exam.index",
            component: require("./components/modules/exam/index").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/exam/edit/:id",
            name: "exam.edit",
            component: require("./components/modules/exam/edit").default,
            beforeEnter: verifyAccess,
            props: true
        },
        {
            path: "/examCreate",
            name: "exam.create",
            component: require("./components/modules/exam/create").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/exam/view/:id",
            name: "exam.view",
            component: require("./components/modules/exam/view").default,
            beforeEnter: verifyAccess,
            props: true
        },
        {
            path: "/examLoad",
            name: "exam.load",
            component: require("./components/modules/exam/load").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/examLoadHistory",
            name: "examLoadHistory.load",
            component: require("./components/modules/exam/loadHistory").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/report",
            name: "report.index",
            component: require("./components/modules/report/index").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/reportMX",
            name: "reportMX.index",
            component: require("./components/modules/report/mx").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/reportSigte",
            name: "reportSigte.index",
            component: require("./components/modules/report/mxSigte").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/reportBirardsAge",
            name: "reportBirardsAge.index",
            component: require("./components/modules/report/birardsAge").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/patientHistoryClinical",
            name: "patientHistoryClinical.index",
            component: require("./components/modules/report/patientHistoryClinical").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/patientHistory",
            name: "patientHistory.index",
            component: require("./components/modules/report/patientHistory").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/reportMXBirards",
            name: "reportMXBirards.index",
            component: require("./components/modules/report/mxBirards").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/reportMXBiradYears",
            name: "reportMXBiradYears.index",
            component: require("./components/modules/report/mxBiradYear").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/reportMXcoverage",
            name: "reportMXcoverage.index",
            component: require("./components/modules/report/mxCoverage").default,
            beforeEnter: verifyAccess
        },
        {
            path: "/:pathMatch(.*)*",
            component: require("./components/layouts/404").default
        }
    ]
});

router.beforeEach((to, from, next) => {
    console.log('Navegando a:', to.path);
    next();
});

export default router;
