<template>
    <div class="login-cu-container">
        <div v-if="fullscreenLoading" class="loading">
            Iniciando sesión...
        </div>
        <div v-if="error" class="error">
            {{ messageError }}
        </div>
    </div>
</template>

<script>
export default {
    name: 'LoginCU',
    
    data() {
        return {
            listRolePermissionsByUser: [],
            listRolePermissionsByUserFilter: [],
            fullscreenLoading: false,
            error: false,
            messageError: ''
        }
    },
    
    mounted() {
        this.login();
    },
    
    methods: {
        async login() {
            this.fullscreenLoading = true;
            this.error = false;
            
            const url = '/authenticate/logincu/' + this.$route.params.token;
            
            try {
                const response = await this.$axios.get(url);
                
                if (response.data.code === 401) {
                    this.showError('Sesión inválida o usuario no registrado');
                    setTimeout(() => this.loginFailed(), 2000);
                    return;
                }
                
                if (response.data.code === 200 && response.data.authUser) {
                    await this.getListRolePermissionsByUser(response.data.authUser);
                } else {
                    this.showError('Respuesta inesperada del servidor');
                    setTimeout(() => this.loginFailed(), 2000);
                }
                
            } catch (error) {
                console.error('LoginCU error:', error);
                
                if (error.response) {
                    const status = error.response.status;
                    if (status === 401) {
                        this.showError('No autorizado. Redirigiendo...');
                    } else if (status === 419) {
                        this.showError('Error de sesión. Recarga la página.');
                    } else if (status === 500) {
                        this.showError('Error del servidor');
                    } else {
                        this.showError('Error ' + status);
                    }
                } else if (error.request) {
                    this.showError('Error de conexión. Verifica tu red.');
                } else {
                    this.showError('Error inesperado');
                }
                
                setTimeout(() => this.loginFailed(), 3000);
            } finally {
                this.fullscreenLoading = false;
            }
        },
        
        async getListRolePermissionsByUser(authUser) {
            try {
                const route = '/administracion/user/getListRolePermissionsByUser';
                const response = await this.$axios.get(route, {
                    params: { idUser: authUser.id }
                });
                
                this.listRolePermissionsByUser = response.data;
                this.filterListRolePermissionsByUser(authUser);
                
            } catch (error) {
                console.error('Permissions error:', error);
                this.showError('Error obteniendo permisos');
                setTimeout(() => this.loginFailed(), 2000);
            }
        },
        
        filterListRolePermissionsByUser(authUser) {
            this.listRolePermissionsByUserFilter = this.listRolePermissionsByUser.map(x => x.slug);
            
            localStorage.setItem('listRolePermissionsByUser', JSON.stringify(this.listRolePermissionsByUserFilter));
            localStorage.setItem('authUser', JSON.stringify(authUser));
            
            this.loginSuccess();
        },
        
        showError(msg) {
            this.error = true;
            this.messageError = msg;
        },
        
        loginFailed() {
            this.$router.push({name: 'login'});
        },
        
        loginSuccess() {
            this.$router.push({name: 'dashboard.index'});
            // Opcional: location.reload();
        }
    }
}
</script>

<style scoped>
.login-cu-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.loading, .error {
    padding: 20px;
    text-align: center;
}
.error {
    color: red;
}
</style>