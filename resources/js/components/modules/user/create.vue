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
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Nombre</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillCrearUsuario.cNombre" @keyup.enter="setRegistrarUsuario">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Segundo Nombre</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillCrearUsuario.cSegundoNombre" @keyup.enter="setRegistrarUsuario">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Apellido</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillCrearUsuario.cApellido" @keyup.enter="setRegistrarUsuario">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Usuario</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillCrearUsuario.cUsuario" @keyup.enter="setRegistrarUsuario">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Correo Electronico</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillCrearUsuario.cCorreo" @keyup.enter="setRegistrarUsuario">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Contraseña</label>
                        <div class="col-md-9">
                          <el-input placeholder="Ingrese Password" v-model="fillCrearUsuario.cContrasena" @keyup.enter="setRegistrarUsuario" show-password></el-input>
                       </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Fotografía</label>
                        <div class="col-md-9">
                          <input type="file" class="form-control" @change="getFile">
                        </div>
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
            fillCrearUsuario: {
              cNombre: '',
              cSegundoNombre: '',
              cApellido: '',
              cUsuario: '',
              cCorreo: '',
              cContrasena: '',
              oFotografia: ''
            },
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
      methods: {
        limpiarCriterios(){
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
              this.setGuardarUsuario(0);
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
              this.setGuardarUsuario(nIdFile);
            })
        },
        setGuardarUsuario(nIdFile){
          var  url = '/administracion/usuario/setRegistrarUsuario'
          axios.post(url, {
            'cNombre'        : this.fillCrearUsuario.cNombre,
            'cSegundoNombre' : this.fillCrearUsuario.cSegundoNombre,
            'cApellido'      : this.fillCrearUsuario.cApellido,
            'cUsuario'       : this.fillCrearUsuario.cUsuario,
            'cCorreo'        : this.fillCrearUsuario.cCorreo,
            'cContrasena'    : this.fillCrearUsuario.cContrasena,
            'oFotografia'    : nIdFile,

          }).then(response => {
            console.log("Registro Usuario exitosamente");t
            this.fullscreenLoading = false;
            this.$router.push('/user');
          })
        },
        validarRegistrarUsuario() {
            this.error = 0;
            this.mensajeError = [];

            if(!this.fillCrearUsuario.cNombre) {
                this.mensajeError.push("Primer Nombre es un campo obligatorio")
            }
            if(!this.fillCrearUsuario.cSegundoNombre) {
                this.mensajeError.push("Segundo Nombre es un campo obligatorio")
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
