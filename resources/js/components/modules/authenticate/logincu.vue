<template>
</template>

<script>
    export default {
        data() {
            return {
                fillLogin : {
                    userToken: this.$attrs.token

                },
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
                var  url = '/authenticate/logincu/'+this.userToken
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
                sessionStorage.setItem('listRolePermissionsByUser', JSON.stringify(me.listRolePermissionsByUserFilter));
                sessionStorage.setItem('authUser', JSON.stringify(authUser));
                this.loginSuccess();
            },
            validateLogin() {
                this.error = 0;
                this.messageError = [];

                if(!this.fillLogin.email) {
                    this.messageError.push("Email es un campo obligatorio")
                }
                if(!this.fillLogin.pass) {
                    this.messageError.push("Password es un campo obligatorio")
                }
                if(this.messageError.length) {
                    this.error = 1;
                }
                return this.error;
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
