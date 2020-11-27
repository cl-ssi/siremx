<template>
    <div>
        <!-- Navbar -->
        <Navbar :ruta="ruta"></Navbar>
        <!-- Main Sidebar Container -->
        <Sidebar :ruta="ruta" :user="user" :listPermissions="listRolePermissionsByUser"></Sidebar>

        <!-- Main Content Container -->
        <div  class="content-wrapper">
            <transition name="slide-fade" mode="out-in">
                <router-view :ruta="ruta"></router-view>
            </transition>
        </div>

        <!-- Footer -->
        <Footer></Footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
</template>

<script>
    import Navbar from './layouts/Navbar'
    import Sidebar from './layouts/Sidebar'
    import Footer from './layouts/Footer'
    export default {
        props: ['ruta', 'user'],
        data() {
            return {
                listRolePermissionsByUser: []
            }
        },
        components:{Navbar,Sidebar,Footer},
        mounted() {

            this.listRolePermissionsByUser = JSON.parse(localStorage.getItem('listRolePermissionsByUser'));

            EventBus.$on('notifyrolePermissionsByUser',data => {
                this.listRolePermissionsByUser = data;
            })
        },
    }
</script>
