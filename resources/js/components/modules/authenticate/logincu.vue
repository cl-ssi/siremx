<template>

</template>

<script>
    // Este archivo vue permite procesar el login mediante
    // acceso por clave única, los metodos posteriores son
    // los que establecen la conexión con el backend y
    // controladores de laravel.
    export default {
        data() {
            return {
                listRolePermissionsByUser: [],
                listRolePermissionsByUserFilter: [],
                fullscreenLoading: false,
                error: 0,
                messageError: []
            }
        },
        mounted(){
            this.login();
        },
        methods: {
            login() {
              
                this.fullscreenLoading = true;
                var  url = '/authenticate/logincu/'+this.$route.params.token;
                axios.get(url).then(response => {
                    if(response.data.code == 401){
                        this.loginFailed();
                    }
                    if(response.data.code == 200){
                        this.getListRolePermissionsByUser(response.data.authUser);
                    }
                    this.fullscreenLoading = false;
                })
            },
            getListRolePermissionsByUser(authUser) {
                var route = '/administracion/user/getListRolePermissionsByUser'
                axios.get(route,{
                    params: {
                    'idUser': authUser.id
                    }
                }).then( response => {
                    this.listRolePermissionsByUser = response.data;
                    this.filterListRolePermissionsByUser(authUser);
                })
            },
            filterListRolePermissionsByUser(authUser) {
                var me = this;
                me.listRolePermissionsByUser.map(function(x, y){
                    me.listRolePermissionsByUserFilter.push(x.slug)
                })
                localStorage.setItem('listRolePermissionsByUser', JSON.stringify(me.listRolePermissionsByUserFilter));
                localStorage.setItem('authUser', JSON.stringify(authUser));
                this.loginSuccess();
            },
            loginFailed() {
                this.$router.push({name: 'login'})
            },
            loginSuccess() {
                this.$router.push({name: 'dashboard.index'})
                location.reload();
            }
        },
    }
</script>
