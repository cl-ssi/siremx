<template>
    <div>
        <!-- Navbar -->
        <Navbar :ruta="ruta"></Navbar>
        <!-- Main Sidebar Container -->
        <Sidebar :ruta="ruta"></Sidebar>

        <!-- Main Content Container -->
        <Content></Content>

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
    import Content from './layouts/Content'
    import Footer from './layouts/Footer'
    export default {
        props: ['ruta'],
        components:{Navbar,Sidebar,Content,Footer}
    }
</script>
