<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Usuario</h1>
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
                <h3 class="card-title">Editar Usuario</h3>
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
                        <input type="text" class="form-control" v-model="fillEditUser.run" @keyup.enter="setRegistrarUsuario">
                      </div>
                    </div>
                    <div class="col-1 col-sm-1 col-xs-1">
                      <div class="form-group">
                        <label>DV</label>
                        <input type="text" class="form-control" v-model="fillEditUser.dv" @keyup.enter="setRegistrarUsuario">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" v-model="fillEditUser.cNombre" @keyup.enter="setEditUser">
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Segundo Nombre</label>
                        <input type="text" class="form-control" v-model="fillEditUser.cSegundoNombre" @keyup.enter="setEditUser">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" class="form-control" v-model="fillEditUser.cApellido" @keyup.enter="setEditUser">
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" v-model="fillEditUser.cUsuario" @keyup.enter="setEditUser">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Correo Electronico</label>
                        <input type="text" class="form-control" v-model="fillEditUser.cCorreo" @keyup.enter="setEditUser">
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Contraseña</label>
                          <el-input placeholder="Ingrese Password" v-model="fillEditUser.cContrasena" @keyup.enter="setEditUser" show-password></el-input>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Establecimiento</label>
                        <el-select v-model="fillEditUser.establishment" 
                          placeholder="Seleccione"
                            clearable>
                              <el-option
                                v-for="item in listEstablishments"
                                :key="item.id"
                                :label="item.new_code_deis+' - '+item.alias"
                                :value="item.new_code_deis">
                              </el-option>
                        </el-select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Comuna</label>
                          <el-select v-model="fillEditUser.commune" 
                           placeholder="Seleccione"
                            clearable>
                              <el-option
                                v-for="item in listCommunes"
                                :key="item.id"
                                :label="item.code_deis+' - '+item.name"
                                :value="item.code_deis">
                              </el-option>
                          </el-select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Rol</label>
                        <el-select v-model="fillEditUser.idRole" 
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
                          <input type="file" class="form-control" @change="getFile">
                      </div>
                    </div>
                  </div>

                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="setEditUser" 
                    v-loading.fullscreen.lock="fullscreenLoading">Editar</button>
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
            fillEditUser: {
              idUser: this.$attrs.id,
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
              establishment: '',
              commune: ''
            },
            listEstablishments: [],
            listCommunes: [],
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
      mounted(){
        this.getListRoles();
        this.getListEstablishments();
        this.getListCommunes();
        this.getUserById();
      },
      methods: {
        getUserById() {
          this.fullscreenLoading = true;  
          var url = '/administracion/usuario/getListarUsuarios'
          axios.get(url, {
            params: {
              'idUser' : this.fillEditUser.idUser,
            }
          }).then(response => {
            console.log(response.data);
            this.fillEditUser.run            = response.data[0].run;
            this.fillEditUser.dv             = response.data[0].dv;
            this.fillEditUser.cNombre        = response.data[0].firstname;
            this.fillEditUser.cSegundoNombre = response.data[0].secondname;
            this.fillEditUser.cApellido      = response.data[0].lastname;
            this.fillEditUser.cUsuario       = response.data[0].username;
            this.fillEditUser.cCorreo        = response.data[0].email;
            this.fillEditUser.commune        = (response.data[0].commune_id)? response.data[0].commune_id : ''; 
            console.log(((response.data[0].commune_id)? response.data[0].commune_id : '') )
            this.fillEditUser.establishment  = (response.data[0].establishment_id)? response.data[0].establishment_id : ''; 

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
        limpiarCriterios(){
          this.fillEditUser.cNombre        = '';
          this.fillEditUser.cSegundoNombre = '';
          this.fillEditUser.cApellido      = '';
          this.fillEditUser.cUsuario       = '';
          this.fillEditUser.cCorreo        = '';
          this.fillEditUser.cContrasena    = '';
          this.fillEditUser.oFotografia    = '';
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        getFile(e) {
            this.fillEditUser.oFotografia = e.target.files[0];       
        },
        setEditUser() {
            
            if(this.validarRegistrarUsuario()) {
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading = true;
            if(!this.fillEditUser.oFotografia || this.fillEditUser.oFotografia == undefined) {
              this.setSaveUser(0);
            }
            else {
              this.setRegistrarArchivo();
            }
        },
        setRegistrarArchivo() {
            this.form.append('file', this.fillEditUser.oFotografia)
            const config = { headers: {'Content-Type': 'multipart/form-data'}}
            var url = '/archivo/setRegistrarArchivo'
            axios.post(url, this.form, config).then(response =>{
              console.log(response.data)
              var nIdFile = response.data;
              this.setSaveUser(nIdFile);
            }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        setSaveUser(nIdFile){
          var  url = '/administracion/usuario/setEditUser'
          axios.post(url, {
            'run'            : this.fillEditUser.run,
            'dv'             : this.fillEditUser.dv,
            'idUser'         : this.fillEditUser.idUser,
            'cNombre'        : this.fillEditUser.cNombre,
            'cSegundoNombre' : this.fillEditUser.cSegundoNombre,
            'cApellido'      : this.fillEditUser.cApellido,
            'cUsuario'       : this.fillEditUser.cUsuario,
            'establishment'  : this.fillEditUser.establishment,
            'commune'        : this.fillEditUser.commune,
            'cCorreo'        : this.fillEditUser.cCorreo,
            'cContrasena'    : this.fillEditUser.cContrasena,
            'oFotografia'    : nIdFile,

          }).then(response => {
            this.setEditRoleByUser();
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListRoles(){
          var url = '/administracion/role/getListRoles'
          axios.get(url).then(response => {
            this.listRoles = response.data;
            this.getRolByUser();
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListEstablishments() {
          var route = '/administracion/establishments/getListEstablishments'
          axios.get(route).then( response => {
            this.listEstablishments = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListCommunes() {
          var route = '/administracion/communes/getListCommunes'
          axios.get(route).then( response => {
            this.listCommunes = response.data;
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
              'idUser': this.fillEditUser.idUser
            }
          }).then(response => {
            console.log(response.data);
            this.fillEditUser.idRole = (response.data[0].role_id)? response.data[0].role_id : '';
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
        setEditRoleByUser() {
          var  url = '/administracion/user/setEditRoleByUser'
          axios.post(url, {
            'idUser' : this.fillEditUser.idUser,
            'idRole' : this.fillEditUser.idRole,

          }).then(response => {
            this.fullscreenLoading = false;
            Swal.fire({
                icon: 'success',
                title: 'Actualizado',
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
        validarRegistrarUsuario() {
            this.error = 0;
            this.mensajeError = [];

            if(!this.fillEditUser.cNombre) {
                this.mensajeError.push("Primer Nombre es un campo obligatorio")
            }
            if(!this.fillEditUser.cSegundoNombre) {
                this.mensajeError.push("Segundo Nombre es un campo obligatorio")
            }
            if(!this.fillEditUser.cApellido) {
                this.mensajeError.push("El Apellido es un campo obligatorio")
            }
            if(!this.fillEditUser.cUsuario) {
                this.mensajeError.push("El Usuario es un campo obligatorio")
            }
            if(!this.fillEditUser.cCorreo) {
                this.mensajeError.push("El Correo es un campo obligatorio")
            }
            if(!this.fillEditUser.idRole) {
                this.mensajeError.push("Debe seleccionar el Rol, es un campo obligatorio")
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
