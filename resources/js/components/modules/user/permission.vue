<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Asignar Permiso</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/user'">
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
                            <h3 class="card-title">Listar Permisos del Rol {{fillPermission.nameRol}}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                        <template v-if="listPermissionByRoleAssigned.length">
                            <table class="table table-hover table-sm table-header-fixed text-nowrap table-valign-middle projects">
                            <thead>
                                <th>Nombre</th>
                                <th>Url Amigable</th>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listPermissionByRoleAssigned" :key="index">
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
                             <button class="btn btn-flat btn-info btnWidth" @click.prevent="setAddRole">Registrar</button>
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
            fillPermission: {
              idUser: this.$attrs.id,
              nameRol: ''
            },
            listPermissionByRoleAssigned: [],
            listPermissions: [],
            listPermissionsFilter: [],
            listRolePermissionsByUser: [],
            listRolePermissionsByUserFilter: [],
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
        this.getListPermissionsByUser();
        this.getListPermissionByRoleAssigned();
        this.getRolByUser();
      },
      methods: {
        limpiarCriterios(){
          this.fillPermission.name = '';
          this.fillPermission.role = '';
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        getListPermissionByRoleAssigned() {
          var route = '/administracion/user/getListPermissionByRoleAssigned'
          axios.get(route, {
              params: {
                  'idUser' : this.fillPermission.idUser,
              }
          }).then( response => {
            this.listPermissionByRoleAssigned = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getRolByUser(){
          var url = '/administracion/user/getRolByUser'
          axios.get(url,{
            params: {
              'idUser': this.fillPermission.idUser
            }
          }).then(response => {
            console.log(response.data);
            this.fillPermission.nameRol = (response.data.length == 0)? '' : response.data[0].name;
            this.fullscreenLoading = false;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListPermissionsByUser() {
          var route = '/administracion/user/getListPermissionsByUser'
          axios.get(route,{
            params: {
              'idUser': this.fillPermission.idUser
            }
          }).then( response => {
            this.listPermissions = response.data;
            this.filterPermissionsByUser();
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        filterPermissionsByUser() {
          var me = this;
          me.listPermissions.map(function(x, y){
            me.listPermissionsFilter.push({
              'id'      : x.id,
              'name'    : x.name,
              'slug'    : x.slug,
              'checked' : (x.checked ==1) ? true :false


            })
          })
        },
        // Selecciona la fila completa del checkbox
        checkRow(index){
          this.listPermissionsFilter[index].checked = !this.listPermissionsFilter[index].checked;
        },
        setAddRole() {
            
            if(this.validStore()) {
                console.log("en agregar");
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading = true;
            this.setStoreRolePermissionsByUser();
        },
        setStoreRolePermissionsByUser(){
          var  url = '/administracion/user/setStoreRolePermissionsByUser'
          axios.post(url, {
            'idUser'                 : this.fillPermission.idUser,
            'listPermissionsFilter'  : this.listPermissionsFilter

          }).then(response => {
            this.getListRolePermissionsByUser();
            this.fullscreenLoading = false;
             Swal.fire({
                      icon: 'success',
                      title: 'Se otorgaron los permisos del usuario correctamente',
                      showConfirmButton: false,
                      timer: 1500
                    })
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListRolePermissionsByUser() {
          var route = '/administracion/user/getListRolePermissionsByUser'
          axios.get(route).then( response => {
              this.listRolePermissionsByUser = response.data;
              this.filterListRolePermissionsByUser();
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        filterListRolePermissionsByUser() {
            var me = this;
            me.listRolePermissionsByUserFilter = [];
            me.listRolePermissionsByUser.map(function(x, y){
                me.listRolePermissionsByUserFilter.push(x.slug)
            })
            localStorage.setItem('listRolePermissionsByUser', JSON.stringify(me.listRolePermissionsByUserFilter));
            EventBus.$emit('notifyrolePermissionsByUser', me.listRolePermissionsByUserFilter);
            this.fullscreenLoading = false;
             Swal.fire({
                      icon: 'success',
                      title: 'Se otorgaron los permisos del usuario correctamente',
                      showConfirmButton: false,
                      timer: 1500
                    })
        },
        validStore() {
            this.error = 0;
            this.mensajeError = [];

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
