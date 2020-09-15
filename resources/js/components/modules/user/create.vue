<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear Usuario</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
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
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Registrar Usuario</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>
              <div class="card-body">
                <form role="form">
                
                  <div class="row">
                    <div class="col-5 col-sm-5 col-xs-5">
                      <div class="form-group">
                        <label>Run</label>
                        <input type="text" class="form-control" v-model="fillCrearUsuario.run" @keyup.enter="setRegistrarUsuario">
                      </div>
                    </div>
                    <div class="col-1 col-sm-1 col-xs-1">
                      <div class="form-group">
                        <label>DV</label>
                        <input type="text" class="form-control" v-model="fillCrearUsuario.dv" @keyup.enter="setRegistrarUsuario">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" v-model="fillCrearUsuario.cNombre" @keyup.enter="setRegistrarUsuario">
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Segundo Nombre</label>
                        <input type="text" class="form-control" v-model="fillCrearUsuario.cSegundoNombre" @keyup.enter="setRegistrarUsuario">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" class="form-control" v-model="fillCrearUsuario.cApellido" @keyup.enter="setRegistrarUsuario">
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" v-model="fillCrearUsuario.cUsuario" @keyup.enter="setRegistrarUsuario">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Correo Electronico</label>
                        <input type="text" class="form-control" v-model="fillCrearUsuario.cCorreo" @keyup.enter="setRegistrarUsuario">
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Contraseña</label>
                        <el-input placeholder="Ingrese Password" v-model="fillCrearUsuario.cContrasena" @keyup.enter="setRegistrarUsuario" show-password></el-input>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Rol</label>
                        <el-select v-model="fillCrearUsuario.idRole" 
                          placeholder="Seleccione Rol"
                          clearable>
                            <el-option
                              v-for="item in listRoles"
                              :key="item.id"
                              :label="item.name"
                              :value="item.id">
                            </el-option>
                          </el-select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Fotografía</label>
                        <input type="file" class="form-control " @change="getFile">
                      </div>
                    </div>
                  </div>

                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="setRegistrarUsuario" 
                    v-loading.fullscreen.lock="fullscreenLoading">Registrar</button>
                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriterios">Limpiar</button>
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
                    <h5 class="modal-title"> SireMX</h5>
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
            fillCrearUsuario: {
              run: '',
              dv: '',
              cNombre: '',
              cSegundoNombre: '',
              cApellido: '',
              cUsuario: '',
              cCorreo: '',
              cContrasena: '',
              oFotografia: '',
              idRole: '',
            },
            listRoles: [],
            form: new FormData,
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
        this.getListRoles();
      },
      methods: {
        limpiarCriterios(){
          this.fillCrearUsuario.run  = '';
          this.fillCrearUsuario.dv  = '';
          this.fillCrearUsuario.cNombre  = '';
          this.fillCrearUsuario.cSegundoNombre = '';
          this.fillCrearUsuario.cApellido  = '';
          this.fillCrearUsuario.cUsuario  = '';
          this.fillCrearUsuario.cCorreo  = '';
          this.fillCrearUsuario.cContrasena  = '';
          this.fillCrearUsuario.oFotografia  = '';
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        getFile(e) {
            this.fillCrearUsuario.oFotografia = e.target.files[0];       
        },
        setRegistrarUsuario() {
            
            if(this.validarRegistrarUsuario()) {
                console.log("en agregar");
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading = true;
            if(!this.fillCrearUsuario.oFotografia || this.fillCrearUsuario.oFotografia == undefined) {
              this.setStoreUser(0);
            }
            else {
              this.setRegistrarArchivo();
            }
        },
        setRegistrarArchivo() {
            this.form.append('file', this.fillCrearUsuario.oFotografia)
            const config = { headers: {'Content-Type': 'multipart/form-data'}}
            var url = '/archivo/setRegistrarArchivo'
            axios.post(url, this.form, config).then(response =>{
              console.log(response)
              var nIdFile = response.data[0].nIdFile;
              this.setStoreUser(nIdFile);
            }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        setStoreUser(nIdFile){
          var  url = '/administracion/usuario/setRegistrarUsuario'
          axios.post(url, {
            'run'            : this.fillCrearUsuario.run,
            'dv'             : this.fillCrearUsuario.dv,
            'cNombre'        : this.fillCrearUsuario.cNombre,
            'cSegundoNombre' : this.fillCrearUsuario.cSegundoNombre,
            'cApellido'      : this.fillCrearUsuario.cApellido,
            'cUsuario'       : this.fillCrearUsuario.cUsuario,
            'cCorreo'        : this.fillCrearUsuario.cCorreo,
            'cContrasena'    : this.fillCrearUsuario.cContrasena,
            'oFotografia'    : nIdFile,
            'idRole'         : this.fillCrearUsuario.idRole,

          }).then(response => {
            console.log(response.data[0].nIdUsuario);
            console.log(response);
            this.setEditRoleByUser(response.data[0].nIdUsuario);
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        setEditRoleByUser(nIdUsuario) {
          console.log("en funcion");
          var  url = '/administracion/user/setEditRoleByUser'
          axios.post(url, {
            'idUser' : nIdUsuario,
            'idRole' : this.fillCrearUsuario.idRole,

          }).then(response => {
            this.fullscreenLoading = false;
            this.$router.push('/user');
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListRoles(){
          var url = '/administracion/role/getListRoles'
          axios.get(url).then(response => {
            this.listRoles = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        validarRegistrarUsuario() {
            this.error = 0;
            this.mensajeError = [];


            if(!this.fillCrearUsuario.run) {
                this.mensajeError.push("Run es un campo obligatorio")
            }
            if(!this.fillCrearUsuario.cNombre) {
                this.mensajeError.push("Primer Nombre es un campo obligatorio")
            }
            if(!this.fillCrearUsuario.cApellido) {
                this.mensajeError.push("El Apellido es un campo obligatorio")
            }
            if(!this.fillCrearUsuario.cUsuario) {
                this.mensajeError.push("El Usuario es un campo obligatorio")
            }
            if(!this.fillCrearUsuario.cCorreo) {
                this.mensajeError.push("El Correo es un campo obligatorio")
            }
            if(!this.fillCrearUsuario.cContrasena) {
                this.mensajeError.push("La Contraseña es un campo obligatorio")
            }

            //console.log("en Validar"+this.mensajeError)
            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        }
      }
    }
</script>
