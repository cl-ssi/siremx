<template>
    <div v-if="user">
        <!-- Navbar -->
        <Navbar :ruta="ruta" :user="user" />

        <!-- Sidebar -->
        <Sidebar 
            :ruta="ruta" 
            :user="user" 
            :listPermissions="listRolePermissionsByUser"
        />

        <!-- Content -->
        <div class="content-wrapper">
            <transition name="slide-fade" mode="out-in">
                <router-view/>
            </transition>
        </div>

        <!-- Footer -->
        <Footer />

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
</template>

<script>
import Navbar from './layouts/Navbar';
import Sidebar from './layouts/Sidebar';
import Footer from './layouts/Footer';

export default {
    props: ['ruta', 'user'],
    components: { Navbar, Sidebar, Footer },

    data() {
        return {
            user: null,
            listRolePermissionsByUser: []
        }
    },

    mounted() {
        this.user = JSON.parse(localStorage.getItem('authUser'));
        console.log('USER:', this.user);
        this.listRolePermissionsByUser = JSON.parse(
            localStorage.getItem('listRolePermissionsByUser')
        ) || [];

        /* 
        if (window.EventBus) {
            window.EventBus.on('notifyrolePermissionsByUser', data => {
                this.listRolePermissionsByUser = data;
            });
        }
        */
    }
}
</script>