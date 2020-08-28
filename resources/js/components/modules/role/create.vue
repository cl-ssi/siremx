<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear Rol</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/role'">
              <i class="fas fa-arrow-left"></i> Regresar
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Rol</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form role="form">
                        <div class="form-row">
                            <fieldset class="form-group col-12">
                                <label>Nombre Rol</label>
                                <input type="text" class="form-control" v-model="fillCreateRole.name" @keyup.enter="setAddRole">
                            </fieldset>
                        </div>
                        <div class="form-row">
                            <fieldset class="form-group col-12">
                                <label>Url Amigable</label>
                                <input type="text" class="form-control" v-model="fillCreateRole.slug" @keyup.enter="setAddRole">
                                <small class="form-text text-muted">Ej: /OrdenExamen</small>
                            </fieldset>
                        </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-md-6 offset-6">
                            <button class="btn btn-flat btn-info btnWidth" @click.prevent="setAddRole" 
                            v-loading.fullscreen.lock="fullscreenLoading">Registrar</button>
                            <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriterios">Limpiar</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Seleccionar Permiso</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                      <template v-if="listPermissionsFilter.length">
                        <table class="table table-hover table-sm table-header-fixed text-nowrap table-valign-middle projects">
                          <thead>
                            <th>Acción</th>
                            <th>Nombre</th>
                            <th>Url Amigable</th>
                          </thead>
                          <tbody>
                            <tr v-for="(item, index) in listPermissionsFilter" :key="index" @click.prevent="checkRow(index)">
                              <td >
                                <el-checkbox v-model="item.checked"></el-checkbox>
                              </td>
                              <td v-text="item.name"></td>
                              <td v-text="item.slug"></td>
                            </tr>
                          </tbody>
                        </table>
                      </template>
                      <template v-else>
                        <div class="callout callout-info">
                            <h5>No se encontraron resultados...</h5>
                        </div>
                      </template>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-md-4 offset-4">
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" :class="{show: modalShow}" :style=" modalShow ? mostrarModal : ocultarModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Sismam</h5>
                    <button class="close" @click="abrirModal"></button>
                </div>
                <div class="modal-body">
                    <div class="callout callout-danger" v-for="(item, index) in mensajeError" :key="index" v-text="item">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="abrirModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
    export default {
      data(){
          return {
            fillCreateRole: {
              name: '',
              slug: '',
            },
            listPermissions: [],
            listPermissionsFilter: [],
            fullscreenLoading: false,
            modalShow: false,
            mostrarModal: {
              display: 'block',
              background: '#0000006b',
            },
            ocultarModal: {
                display: 'none',
            },
            error: 0,
            mensajeError: []
          }
      },
      computed: {
        
      },
      mounted() {
        this.getListPermissionsByRole();
      },
      methods: {
        limpiarCriterios(){
          this.fillCreateRole.name = '';
          this.fillCreateRole.role = '';
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        getListPermissionsByRole() {
          var route = '/administracion/role/getListPermissionsByRole'
          axios.get(route).then( response => {
            this.listPermissions = response.data;
            this.filterPermissionsByRole();
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        filterPermissionsByRole() {
          var me = this;
          me.listPermissions.map(function(x, y){
            me.listPermissionsFilter.push({
              'id'      : x.id,
              'name'    : x.name,
              'slug'    : x.slug,
              'checked' : false


            })
          })
        },
        // Selecciona la fila completa del checkbox
        checkRow(index){
          this.listPermissionsFilter[index].checked = !this.listPermissionsFilter[index].checked;
        },
        setAddRole() {
            
            if(this.validAddRole()) {
                console.log("en agregar");
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading = true;
            this.setStoreRole();
        },
        setStoreRole(){
          var  url = '/administracion/role/setStoreRolePermissions'
          axios.post(url, {
            'name'                   : this.fillCreateRole.name,
            'slug'                   : this.fillCreateRole.slug,
            'listPermissionsFilter'  : this.listPermissionsFilter

          }).then(response => {
            console.log("Se creao Rol exitosamente");
            this.fullscreenLoading = false;
            this.$router.push('/role');
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        validAddRole() {
            this.error = 0;
            this.mensajeError = [];
            if(!this.fillCreateRole.name) {
                this.mensajeError.push("Nombre es un campo obligatorio")
            }
            if(!this.fillCreateRole.slug) {
                this.mensajeError.push("Url es un campo obligatorio")
            }

            let contador = 0;
            this.listPermissionsFilter.map(function(x, y){
              if(x.checked == true) {
                contador++;
              }
            })
            if(contador == 0) {
              this.mensajeError.push("Debe seleccionar al menos un permiso")
            }

            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        }
      }
    }
</script>
