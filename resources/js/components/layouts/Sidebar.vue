<template>
    <aside class="main-sidebar sidebar-dark-info elevation-4">
        <!-- Brand Logo -->
        <router-link class="brand-link" :to="'/'" >
          <img :src="ruta + '/img/mxlogo.png'"
               alt="siremx logo"
               class="brand-image ">
          <span class="brand-text font-weight">SIREMX</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img :src="ruta + '/img/avatar.png'" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="javascript:void(0)" class="d-block">{{user?.fullname || ''}}</a>
            </div>
          </div>

          <nav class="mt-3 pb-3 mb-3 user-panel ">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item has-treeview">
                  <router-link class="nav-link" :to="'/auth/logout'" @click.prevent="handleLogout">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Cerrar Sesión</p>
                  </router-link>
              </li>
            </ul>
          </nav>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              
              <li class="nav-item has-treeview">
                <template v-if="listPermissions.includes('dashboard.index')">
                  <router-link class="nav-link active" :to="'/'" >
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                  </router-link>
                </template>
              </li>

              <li class="nav-item has-treeview">
                <template v-if="listPermissions.includes('dashboardAudit.index')">
                  <router-link class="nav-link bg-purple active" :to="'/dashboardAudit'" >
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard Auditoría</p>
                  </router-link>
                </template>
              </li>

              <!-- MENÚ GESTIÓN - Desplegable -->
              <template v-if="listPermissions.includes('exam.index','exam.load')">
                <li class="nav-item has-treeview" :class="{ 'menu-open': menus.gestion }">
                  <a href="javascript:void(0)" class="nav-link" @click.prevent="toggleMenu('gestion')">
                    <i class="nav-icon fas fa-notes-medical"></i>
                    <p>
                      Examen Mamario
                      <i class="right fas fa-angle-left" :class="{ 'fa-rotate-90': menus.gestion }"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" v-show="menus.gestion">
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('exam.create')">
                        <router-link class="nav-link" :to="'/examCreate'" >
                          <i class="far fa-circle nav-icon"></i>
                          <p>Hito1 - Ingreso</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('exam.index')">
                        <router-link class="nav-link" :to="'/exam'" >
                          <i class="far fa-circle nav-icon"></i>
                          <p>Hito2 - Ingreso Resultado</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('exam.load')">
                        <router-link class="nav-link" :to="'/examLoad'" >
                          <i class="far fa-circle nav-icon"></i>
                          <p>Carga Masiva</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('examLoadHistory.load')">
                        <router-link class="nav-link" :to="'/examLoadHistory'" >
                          <i class="far fa-circle nav-icon"></i>
                          <p>Historial de Cargas Masivas</p>
                        </router-link>
                      </template>
                    </li>
                  </ul>
                </li>
              </template>

              <template v-if="listPermissions.includes('patient.index')">
                <li class="nav-item">
                  <template v-if="listPermissions.includes('patient.index')">
                    <router-link class="nav-link" :to="'/patient'" >
                      <i class="nav-icon fas fa-users "></i>
                      <p>Pacientes</p>
                    </router-link>
                  </template>
                </li>
              </template>
              
              <!-- MENÚ REPORTES - Desplegable -->
              <template v-if="listPermissions.includes('patientHistoryClinical.index')">
                <li class="nav-header">REPORTES</li>
                <li class="nav-item has-treeview" :class="{ 'menu-open': menus.reportes }">
                  <a href="javascript:void(0)" class="nav-link" @click.prevent="toggleMenu('reportes')">
                    <i class="nav-icon fas fa-notes-medical"></i>
                    <p>
                      Examenes Mamarios
                      <i class="right fas fa-angle-left" :class="{ 'fa-rotate-90': menus.reportes }"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" v-show="menus.reportes">
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('patientHistoryClinical.index')">
                        <router-link class="nav-link" :to="'/patientHistoryClinical'" >
                          <i class="fas fa-file-contract nav-icon"></i>
                          <p>Cartola Paciente</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('patientHistory.index')">
                        <router-link class="nav-link" :to="'/patientHistory'" >
                          <i class="fas fa-file-contract nav-icon"></i>
                          <p>Historial Paciente</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('reportMX.index')">
                        <router-link class="nav-link" :to="'/reportMX'">
                          <i class="fas fa-file-contract nav-icon"></i>
                          <p>Reporte MX</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('reportMXBirards.index')">
                        <router-link class="nav-link" :to="'/reportMXBirards'">
                          <i class="fas fa-file-contract nav-icon"></i>
                          <p>MX por BIRARDS</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('reportMXBiradYears.index')">
                        <router-link class="nav-link" :to="'/reportMXBiradYears'">
                          <i class="fas fa-file-contract nav-icon"></i>
                          <p>Antiguedad MX</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('reportMXcoverage.index')">
                        <router-link class="nav-link" :to="'/reportMXcoverage'">
                          <i class="fas fa-file-contract nav-icon"></i>
                          <p>Cobertura MX</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('reportMXTarget.index')">
                        <router-link class="nav-link" :to="'/reportMXTarget'">
                          <i class="fas fa-file-contract nav-icon"></i>
                          <p>Reporte Focalización</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('reportBirardsAge.index')">
                        <router-link class="nav-link" :to="'/reportBirardsAge'">
                          <i class="fas fa-file-contract nav-icon"></i>
                          <p>Reporte REM</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('reportSigte.index')">
                        <router-link class="nav-link" :to="'/reportSigte'">
                          <i class="fas fa-file-contract nav-icon"></i>
                          <p>Reporte SIGTE (En construcción)</p>
                        </router-link>
                      </template>
                    </li>
                  </ul>
                </li>
              </template>
              
              <!-- MENÚ ADMINISTRACIÓN - Desplegable -->
              <template v-if="listPermissions.includes('user.index','role.index','permission.index')">
                <li class="nav-header">ADMINISTRACIÓN</li>
                <li class="nav-item has-treeview" :class="{ 'menu-open': menus.admin }">
                  <a href="javascript:void(0)" class="nav-link" @click.prevent="toggleMenu('admin')">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                      Configuración
                      <i class="right fas fa-angle-left" :class="{ 'fa-rotate-90': menus.admin }"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" v-show="menus.admin">
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('user.index')">
                        <router-link class="nav-link" :to="'/user'" >
                          <i class="nav-icon fas fa-user"></i>
                          <p>Usuarios</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('role.index')">
                        <router-link class="nav-link" :to="'/role'" >
                          <i class="nav-icon fas fa-unlock-alt"></i>
                          <p>Roles</p>
                        </router-link>
                      </template>
                    </li>
                    <li class="nav-item">
                      <template v-if="listPermissions.includes('permission.index')">
                        <router-link class="nav-link" :to="'/permission'" >
                          <i class="nav-icon fas fa-key"></i>
                          <p>Permisos</p>
                        </router-link>
                      </template>
                    </li>
                  </ul>
                </li>
              </template>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
export default {
    props: ['ruta', 'user', 'listPermissions'],
    
    data() {
        return {
            fullscreenLoading: false,
            // Estado de menús: cambia a true para abiertos por defecto
            menus: {
                gestion: true,    // Examen Mamario
                reportes: true,   // Reportes
                admin: false       // Administración
            }
        }
    },
    
    methods: {
        toggleMenu(menuName) {
            // Cierra los otros menús si quieres comportamiento "accordion" 
            // (solo uno abierto a la vez). Elimina este bloque si quieres 
            // múltiples abiertos.
            /*
            for (let key in this.menus) {
                if (key !== menuName) {
                    this.menus[key] = false;
                }
            }
            */
            
            // Toggle el menú clickeado
            this.menus[menuName] = !this.menus[menuName];
        },
        
        handleLogout() {
            this.fullscreenLoading = true;
            
            // Limpiar todo antes de salir
            localStorage.clear();
            sessionStorage.clear();
            
            // Redirigir forzando recarga completa (evita problemas de chunks)
            window.location.href = '/auth/logout';
        }
    }
}
</script>

<style scoped>
/* Rotación suave del icono de flecha */
.fa-angle-left {
    transition: transform 0.3s ease;
}

/* Si AdminLTE no tiene esta clase, la agregamos */
.fa-rotate-90 {
    transform: rotate(-90deg);
}
</style>