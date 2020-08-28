<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Usuario</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <template v-if="listRolePermissionsByUser.includes('user.create')">
                <router-link class="btn btn-info btn-sm" :to="{name:'user.create'}">
                  <i class="fas fa-plus-square"></i> Nuevo Usuario
                </router-link>
            </template>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Criterios de Búsqueda</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>
              <div class="card-body">
                <form role="form">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Nombre</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillBsqUsuario.cNombre" @keyup.enter="getListarUsuarios">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Usuario</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillBsqUsuario.cUsuario" @keyup.enter="getListarUsuarios">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Correo Electronico</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillBsqUsuario.cCorreo" @keyup.enter="getListarUsuarios">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Estado</label>
                        <div class="col-md-9">
                          <el-select v-model="fillBsqUsuario.cEstado" 
                          placeholder="Seleccione un estado"
                          clearable>
                            <el-option
                              v-for="item in listEstados"
                              :key="item.value"
                              :label="item.label"
                              :value="item.value">
                            </el-option>
                          </el-select>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="getListarUsuarios">Buscar</button>
                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Bandeja de Resultados</h3>
              </div>
              <div class="card-body table-responsive">
                <template v-if="listarUsuariosPaginated.length">
                  <table class="table table-hover table-sm  table-striped table-header-fixed text-nowrap table-valign-middle projects">
                    <thead>
                      <th>Fotografía</th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                      <th class="text-right"></th>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in listarUsuariosPaginated" :key="index">
                        <td>
                          <template v-if="!item.profile_image">
                            <li class="user-block">
                              <img src="/img/avatar.png" alt="" :alt="item.username" class="profile-avatar-img img-fluid img-circle img-circle img-size-20 mr-2">
                            </li>
                          </template>
                          <template v-else>
                            <li class="user-block">
                              <img :src="item.profile_image" alt="" :alt="item.username" class="profile-avatar-img img-fluid img-circle img-circle img-size-20 mr-2">
                            </li>
                          </template>
                        </td>
                        <td v-text="item.fullname"></td>
                        <td v-text="item.email"></td>
                        <td v-text="item.username"></td>
                        <td>
                          <template v-if="item.state == 'A'">
                            <span class="badge badge-success" v-text="item.state_alias"></span>
                          </template>
                          <template v-else>
                            <span class="badge badge-danger" v-text="item.state_alias"></span>
                          </template>
                        </td>
                        <td class="text-right">
                          <template v-if="item.state == 'A'">
                            <!--<router-link class="btn btb-flat btn-xs btn-default" :to="'/'">
                              <i class="fas fa-folder"></i> 
                            </router-link>-->
                            <!--Editar-->
                            <template v-if="listRolePermissionsByUser.includes('user.edit')">
                              <router-link class="btn btb-flat btn-xs btn-default" :to="{name: 'user.edit', params: {id: item.id}}">
                                <i class="fas fa-pencil-alt"></i> 
                              </router-link>
                            </template>
                            <template v-if="listRolePermissionsByUser.includes('user.permission')">
                              <router-link class="btn btb-flat btn-xs btn-default" :to="{name: 'user.permission', params: {id: item.id}}">
                                <i class="fas fa-key"></i> Permisos
                              </router-link>
                            </template>
                            <template v-if="listRolePermissionsByUser.includes('user.activate')">
                              <button class="btn btb-flat btn-xs btn-default"  @click.prevent="setChangeUserState(1, item.id)">
                                <i class="fas fa-trash text-danger"></i> 
                              </button>
                            </template>
                          </template>
                          <template v-else>
                            <template v-if="listRolePermissionsByUser.includes('user.activate')">
                              <button class="btn btb-flat btn-xs btn-default"  @click.prevent="setChangeUserState(2, item.id)">
                                <i class="fas fa-check text-success"></i> 
                              </button>
                            </template>
                           </template>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm pagination-secondary m-0 float-right">
                      <li class="page-item" v-if="pageNumber > 0">
                        <a href="#" class="page-link" @click.prevent="prevPage">Ant</a>
                      </li>
                      <li class="page-item" v-for="(page, index) in pagesList" :key="index"
                        :class="[page == pageNumber ? 'active' : '']">
                        <a href="#" class="page-link" @click.prevent="selectPage(page)">{{ page+1 }}</a>
                      </li>
                      <li class="page-item" v-if="pageNumber < pageCount -1">
                        <a href="#" class="page-link" @click.prevent="nextPage">Pos</a>
                      </li>
                    </ul>
                  </div>
                </template>
                <template v-else>
                  <div class="callout callout-info">
                      <h5>No se encontraron resultados...</h5>
                  </div>
                </template>
              </div>
            </div>
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
            fillBsqUsuario: {
              cNombre: '',
              cUsuario: '',
              cCorreo: '',
              cEstado: ''
            },
            listUsuarios: [],
            listRolePermissionsByUser: JSON.parse(sessionStorage.getItem('listRolePermissionsByUser')),
            listEstados: [
              {value: 'A', label: 'Activo'},
              {value: 'I', label: 'Inactivo'}
            ],
            pageNumber: 0,
            perPage: 10
          }
      },
      computed: {
        //  Obtener el número de páginas
        pageCount() {
          let a = this.listUsuarios.length,
              b = this.perPage;
              return Math.ceil(a/b);
        },
        // Obtener registros paginados
        listarUsuariosPaginated() {
          let inicio = this.pageNumber * this.perPage,
              fin    = inicio + this.perPage;
          return this.listUsuarios.slice(inicio,fin)
        },
        pagesList() {
          let a = this.listUsuarios.length,
              b = this.perPage;
              let pageCount = Math.ceil(a/b);
              let count = 0;
              let pagesArray = [];

              while (count < pageCount) {
                pagesArray.push(count);
                count++;
              }
              return pagesArray;
        },
      },
      methods: {
        limpiarCriteriosBsq(){
          this.fillBsqUsuario.cNombre  = '';
          this.fillBsqUsuario.cUsuario = '';
          this.fillBsqUsuario.cCorreo  = '';
          this.fillBsqUsuario.cEstado  = '';
        },
        limpiarBandejaUsuarios(){
          this.listUsuarios = [];
        },
        getListarUsuarios(){
          var url = '/administracion/usuario/getListarUsuarios'
          axios.get(url, {
            params: {
              'cNombre' : this.fillBsqUsuario.cNombre,
              'cUsuario': this.fillBsqUsuario.cUsuario,
              'cCorreo' : this.fillBsqUsuario.cCorreo,
              'cEstado' : this.fillBsqUsuario.cEstado,
            }
          }).then(response => {
            console.log(response.data)
            this.inicializarPaginacion();
            this.listUsuarios = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        nextPage() {
          this.pageNumber++;
        },
        prevPage() {
          this.pageNumber--;
        },
        selectPage(page) {
          this.pageNumber = page;
        },
        inicializarPaginacion() {
          this.pageNumber = 0;
        },
        setChangeUserState(op, id) {
          Swal.fire({
            title: '¿Está Seguro de '+((op == 1)? 'desactivar': 'activar')+' el usuario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: ((op == 1)? 'Si desactivar': 'Si, activar')
          }).then((result) => {
              if (result.value) {
              // AQUI IRA LA CONFIRMACIÓN DEL BOTON Y PETICIÓN DEL SERVIDOR
                var  url = '/administracion/user/setChangeUserState'
                axios.post(url, {
                  'idUser'        : id,
                  'state' : ((op == 1)? 'I': 'A'),

                }).then(response => {
                     Swal.fire({
                      icon: 'success',
                      title: 'Se '+((op == 1)? 'desactivo': 'activo')+'el usuario',
                      showConfirmButton: false,
                      timer: 1500
                    })
                    this.getListarUsuarios();
                }).catch(error => {
                    if(error.response.status == 401){
                      this.$router.push({name: 'login'})
                      location.reload();
                      sessionStorage.clear();
                      this.fullscreenLoading = false;
                    }
                })
              
            }
          })
        }
      }
    }
</script>
