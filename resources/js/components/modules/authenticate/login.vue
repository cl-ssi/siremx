<template>
    <div class="login-box">
        <div class="login-logo">
            <router-link :to="{ name: 'login' }">
                <b class="text-default">SIRE</b>MX
            </router-link>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">

                <h6 class="mb-3 text-center">Utilizando tu Clave Única</h6>

                <a class="btn-cu btn-m btn-color-estandar m-auto"
                    href="https://uni.saludtarapaca.gob.cl/claveunica/siremx"
                    title="Este es el botón Iniciar sesión de ClaveÚnica">
                    <span class="cl-claveunica"></span>
                    <span class="texto">Iniciar sesión</span>
                </a>

                <hr>

                <h6 class="login-box-msg">O con tu cuenta del sistema</h6>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="email" @keyup.enter="login" v-model="fillLogin.email" class="form-control"
                            placeholder="Usuario">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" @keyup.enter="login" v-model="fillLogin.pass" class="form-control"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <template v-if="error">
                            <div v-for="(e, index) in messageError" :key="index" class="callout callout-danger">{{ e }}
                            </div>

                        </template>
                    </div>
                </div>

                <div class="social-auth-links text-center mb-3">
                    <!-- Temporal remove: v-loading.fullscreen.lock="fullscreenLoading" -->
                    <button class="btn btn-block btn-info" @click.prevent="login">
                        <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                    </button>
                </div>

                <hr>

                <a class="btn-cu btn-m btn-color-estandar m-auto bg-secondary"
                    href="/claveunica?redirect=L3NpcmVteC9sb2dpbmN1"
                    title="Este es el botón Iniciar sesión de ClaveÚnica">
                    <span class="cl-claveunica"></span>
                    <span class="texto">Iniciar sesión</span>
                </a>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            fillLogin: {
                email: '',
                pass: ''

            },
            listRolePermissionsByUser: [],
            listRolePermissionsByUserFilter: [],
            fullscreenLoading: false,
            error: 0,
            messageError: []
        }
    },
    methods: {
        login() {
            if (this.validateLogin()) {
                return;
            }
            this.fullscreenLoading = true;
            var url = '/authenticate/login'
            axios.post(url, {
                'email': this.fillLogin.email,
                'pass': this.fillLogin.pass,
            }).then(response => {
                console.log('Login POST response:', response.data.code); // ← agregar
                if (response.data.code == 401) {
                    this.loginFailed();
                }
                if (response.data.code == 200) {
                    console.log('Llamando getListRolePermissions...'); // ← agregar
                    this.getListRolePermissionsByUser(response.data.authUser);
                }
                this.fullscreenLoading = false;
                console.log('Login response completa:', response.data);
            }).catch(e => {
                console.log('Login POST error:', e.message); // ← agregar
            })
        },
        getListRolePermissionsByUser(authUser) {
            var route = '/administracion/user/getListRolePermissionsByUser'
            axios.get(route, {
                params: {
                    'idUser': authUser.id
                }
            }).then(response => {
                console.log('response.data:', response.data);
                this.listRolePermissionsByUser = response.data;
                if (Array.isArray(response.data)) {
                    this.listRolePermissionsByUser = response.data;
                } else if (response.data.data && Array.isArray(response.data.data)) {
                    this.listRolePermissionsByUser = response.data.data; // paginado
                } else {
                    this.listRolePermissionsByUser = Object.values(response.data); // objeto
                }
                this.filterListRolePermissionsByUser(authUser);
            }).catch(error => {
                console.log('ERROR status:', error.response?.status);
                console.log('ERROR data:', error.response?.data);
                console.log('ERROR message:', error.message);
            })
        },
        filterListRolePermissionsByUser(authUser) {
            var me = this;
            console.log('primer item permisos:', me.listRolePermissionsByUser[0]); // ← agregar
            me.listRolePermissionsByUser.map(function (x, y) {
                me.listRolePermissionsByUserFilter.push(x.slug)
            })
            const plainArray = Array.from(me.listRolePermissionsByUserFilter);
            console.log('slugs a guardar:', plainArray); // ← agregar
            localStorage.setItem('listRolePermissionsByUser', JSON.stringify(plainArray));
            localStorage.setItem('authUser', JSON.stringify(authUser));
            this.loginSuccess();
        },
        validateLogin() {
            this.error = 0;
            this.messageError = [];

            if (!this.fillLogin.email) {
                this.messageError.push("Email es un campo obligatorio")
            }
            if (!this.fillLogin.pass) {
                this.messageError.push("Password es un campo obligatorio")
            }
            if (this.messageError.length) {
                this.error = 1;
            }
            return this.error;
        },
        loginFailed() {
            this.error = 0;
            this.messageError = [];
            this.messageError.push("Esta cuenta no coincide con nuestros registros.")
            this.fillLogin.pass = '';
            if (this.messageError.length) {
                this.error = 1;
            }
            return this.error;
        },
        loginSuccess() {
            this.$router.push({ name: 'dashboard.index' })
            // location.reload();
        }
    },
}
</script>
