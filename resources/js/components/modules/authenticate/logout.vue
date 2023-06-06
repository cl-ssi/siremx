<template>

</template>

<script>
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
            this.logout();
        },
        methods: {
            logout() {
                this.fullscreenLoading = true;

            //   var url = '/claveunica/logout'
            //   axios.post(url).then(response => {
            //       alert(response.data)
            //       console.log('Logout desde clave unica se ha completado satisfactoriamente')
            //   })

                var url = '/authenticate/logout'
                axios.get(url).then(response => {
                    if(response.data.code == 204){
                        localStorage.clear();
                        this.fullscreenLoading = true;
                        this.$router.push({name: 'login'})
                        location.reload();
                    }
                })
            }
        },
    }
</script>
