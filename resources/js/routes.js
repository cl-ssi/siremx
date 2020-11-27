import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

function verifyAccess(to, from, next) {
    let authUser = JSON.parse(localStorage.getItem("authUser"));
    if (authUser) {
        let listRolePermissionsByUser = JSON.parse(
            localStorage.getItem("listRolePermissionsByUser")
        );
        if (listRolePermissionsByUser.includes(to.name)) {
            next();
        } else {
            let listRolePermissionsByUserFilter = [];
            listRolePermissionsByUser.map(function(x) {
                if (x.includes("index")) {
                    listRolePermissionsByUserFilter.push(x);
                }
            });
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

export default new Router({
    routes: [
        {
            path: "/login",
            name: "login",
            component: require("./components/modules/authenticate/login")
                .default
        },
        {
            path: "/logincu/:token",
            name: "logincu",
            component: require("./components/modules/authenticate/logincu")
                .default
        },

        {
            path: "/",
            name: "dashboard.index",
            component: require("./components/modules/dashboard/index").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/user",
            name: "user.index",
            component: require("./components/modules/user/index").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/user/create",
            name: "user.create",
            component: require("./components/modules/user/create").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/user/edit/:id",
            name: "user.edit",
            component: require("./components/modules/user/edit").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            },
            props: true
        },

        {
            path: "/user/permission/:id",
            name: "user.permission",
            component: require("./components/modules/user/permission").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            },
            props: true
        },

        {
            path: "/role",
            name: "role.index",
            component: require("./components/modules/role/index").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/role/create",
            name: "role.create",
            component: require("./components/modules/role/create").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/role/edit/:id",
            name: "role.edit",
            component: require("./components/modules/role/edit").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            },
            props: true
        },

        {
            path: "/permission",
            name: "permission.index",
            component: require("./components/modules/permission/index").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/permission/create",
            name: "permission.create",
            component: require("./components/modules/permission/create")
                .default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/permission/edit/:id",
            name: "permission.edit",
            component: require("./components/modules/permission/edit").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            },
            props: true
        },

        {
            path: "/dashboard",
            component: require("./components/modules/dashboard/index").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/patient",
            name: "patient.index",
            component: require("./components/modules/patient/index").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/patient/edit/:id",
            name: "patient.edit",
            component: require("./components/modules/patient/edit").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            },
            props: true
        },

        {
            path: "/patient/create",
            name: "patient.create",
            component: require("./components/modules/patient/create").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/exam",
            name: "exam.index",
            component: require("./components/modules/exam/index").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/exam/edit/:id",
            name: "exam.edit",
            component: require("./components/modules/exam/edit").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            },
            props: true
        },

        {
            path: "/examCreate",
            name: "exam.create",
            component: require("./components/modules/exam/create").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/exam/create",
            name: "exam.create",
            component: require("./components/modules/exam/create").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/exam/view/:id",
            name: "exam.view",
            component: require("./components/modules/exam/view").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            },
            props: true
        },

        {
            path: "/examLoad",
            name: "exam.load",
            component: require("./components/modules/exam/load").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/examLoadHistory",
            name: "examLoadHistory.load",
            component: require("./components/modules/exam/loadHistory").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        /* REPORTS ROUTER */
        {
            path: "/report",
            name: "report.index",
            component: require("./components/modules/report/index").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/reportMX",
            name: "reportMX.index",
            component: require("./components/modules/report/mx").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/reportSigte",
            name: "reportSigte.index",
            component: require("./components/modules/report/mxSigte").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/reportBirardsAge",
            name: "reportBirardsAge.index",
            component: require("./components/modules/report/birardsAge")
                .default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/patientHistoryClinical",
            name: "patientHistoryClinical.index",
            component: require("./components/modules/report/patientHistoryClinical")
                .default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/patientHistory",
            name: "patientHistory.index",
            component: require("./components/modules/report/patientHistory")
                .default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/reportMXBirards",
            name: "reportMXBirards.index",
            component: require("./components/modules/report/mxBirards").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        {
            path: "/reportMXBiradYears",
            name: "reportMXBiradYears.index",
            component: require("./components/modules/report/mxBiradYear").default,
            beforeEnter: (to, from, next) => {
                verifyAccess(to, from, next);
            }
        },

        { path: "*", component: require("./components/layouts/404").default }
    ],
    mode: "history",
    base: "/siremx/",
    linkActiveClass: "active"
});
