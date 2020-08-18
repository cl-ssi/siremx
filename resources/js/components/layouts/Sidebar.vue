<template>
    <aside class="main-sidebar sidebar-dark-info elevation-4">
        <!-- Brand Logo -->
        <a href="../../index3.html" class="brand-link">
          <img :src="ruta + '/img/adminLteLogo.png'"
               alt="sismam logo"
               class="brand-image img-circle elevation-3"
               style="opacity: .8">
          <span class="brand-text font-weight-light">SISMAM</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img :src="ruta + '/img/avatar.png'" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block">Jorge Cruz</a>
            </div>
          </div>

          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
              <a href="#" class="d-block" @click.prevent="logout" v-loading.fullscreen.lock="fullscreenLoading">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
              </a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              <li class="nav-item has-treeview">
                <router-link class="nav-link active" :to="'/'" >
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </router-link>
              </li>
              
              <li class="nav-header">GESTIÓN</li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-notes-medical"></i>
                  <p>
                    Mamografías
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                  <li class="nav-item">
                    <router-link href="#" class="nav-link" :to="'/exam'">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ingreso de Exámen</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link href="#" class="nav-link" :to="'/examLoad'">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Carga Masiva</p>
                    </router-link>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="'/patient'" >
                  <i class="nav-icon fas fa-user-friends"></i>
                  <p>
                    Pacientes
                  </p>
                </router-link>
              </li>
              

              <li class="nav-header">REPORTES</li>
              <!--<li class="nav-item">
                <router-link class="nav-link" :to="'/report'" >
                  <i class="nav-icon fas fa-chart-line"></i>
                  <p>Exámenes</p>
                </router-link>
              </li>-->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-notes-medical"></i>
                  <p>
                    Mamografías
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                  <li class="nav-item">
                    <router-link class="nav-link" :to="'/patientHistory'">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Historial Paciente</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link class="nav-link" :to="'/reportMX'">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Reporte MX</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link class="nav-link" :to="'/reportMXBirards'">
                      <i class="far fa-circle nav-icon"></i>
                      <p>MX por BIRARDS</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link class="nav-link" :to="'/reportBirardsAge'">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Birards por Edad</p>
                    </router-link>
                  </li>
                </ul>
              </li>
              
              <li class="nav-header">ADMINISTRACIÓN</li>
              <li class="nav-item">
                <router-link class="nav-link" :to="'/user'" >
                  <i class="nav-icon fas fa-user"></i>
                  <p>Usuarios</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="'/role'" >
                  <i class="nav-icon fas fa-unlock-alt"></i>
                  <p>Roles</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="'/permission'" >
                  <i class="nav-icon fas fa-key"></i>
                  <p>Permisos</p>
                </router-link>
              </li>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    export default {
      props:['ruta'],
      data() {
            return {
                fullscreenLoading: false
            }
        },
      methods: {
        logout() {
          this.fullscreenLoading = true;
          var  url = '/authenticate/logout'
          axios.post(url).then(response => {
            if(response.data.code == 204){
              this.$router.push({name: 'login'})
              location.reload();
              this.fullscreenLoading = false;
            }
          })
        }
      }
    }
</script>
