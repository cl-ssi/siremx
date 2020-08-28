<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear Paciente</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/patient'">
              <i class="fas fa-arrow-left"></i> Regresar
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Registrar Paciente</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>
              <div class="card-body">
                <form role="form">
                  
                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Run</label>
                          <input type="text" class="form-control" v-model="fillCreatePatient.run" @keyup.enter="setRegistrarUsuario">
                          <small class="form-text text-muted">Sin punto ni guión ni digito verificador: Ej. 11111111</small>
                      </fieldset>
                      <fieldset class="form-group col-1">
                        <label>DV</label>
                          <input type="text" class="form-control" v-model="fillCreatePatient.dv" @keyup.enter="setRegistrarUsuario">
                          <small class="form-text text-muted">D.V. : Ej: 4</small>
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Nombre</label>
                           <input type="text" class="form-control" v-model="fillCreatePatient.name" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Apellido Paterno</label>
                           <input type="text" class="form-control" v-model="fillCreatePatient.fathers_family" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Apellido Materno</label>
                          <input type="text" class="form-control" v-model="fillCreatePatient.mothers_family" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Genero</label>
                           <el-select v-model="fillCreatePatient.gender" 
                              placeholder="Seleccione Genero"
                              clearable>
                                <el-option
                                  v-for="item in listGender"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Fecha de Nacimiento</label>
                          <el-date-picker
                            v-model="fillCreatePatient.birthday"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd"
                            default-value="1990-01-02">
                          </el-date-picker>
                          <small class="form-text text-muted"></small>
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Telefóno</label>
                          <input type="text" class="form-control" v-model="fillCreatePatient.telephone" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col-8">
                          <label>Dirección</label>
                           <input type="text" class="form-control" v-model="fillCreatePatient.address" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
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
            fillCreatePatient: {
               run : '',
               dv  : '',
               name  : '',
               fathers_family : '',
               mothers_family  : '',
               gender  : '',
               birthday  : '',
               telephone  : '',
               address  : ''
            },
            listGender: [
              {value: 'female', label: 'Femenino'},
              {value: 'male', label: 'Masculino'},
              {value: 'other', label: 'Otro'},
              {value: 'unknown', label: 'Prefiero no decir'}
            ],
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
          this.fillCreatePatient.run = '';
          this.fillCreatePatient.dv  = '';
          this.fillCreatePatient.name  = '';
          this.fillCreatePatient.fathers_family = '';
          this.fillCreatePatient.mothers_family  = '';
          this.fillCreatePatient.gender  = '';
          this.fillCreatePatient.birthday  = '';
          this.fillCreatePatient.telephone  = '';
          this.fillCreatePatient.address  = '';
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        getFile(e) {
            this.fillCreatePatient.oFotografia = e.target.files[0];       
        },
        setRegistrarUsuario() {
            
            if(this.validarRegistrarUsuario()) {
                console.log("en agregar");
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading = true;
            this.setGuardarUsuario();
        },
        setGuardarUsuario(){
          var  url = '/administracion/patient/setStorePatient'
          axios.post(url, {
            'run'            : this.fillCreatePatient.run,
            'dv'             : this.fillCreatePatient.dv,
            'name'           : this.fillCreatePatient.name,
            'fathers_family' : this.fillCreatePatient.fathers_family,
            'mothers_family' : this.fillCreatePatient.mothers_family,
            'gender'         : this.fillCreatePatient.gender,
            'birthday'       : this.fillCreatePatient.birthday,
            'telephone'      : this.fillCreatePatient.telephone,
            'address'        : this.fillCreatePatient.address,

          }).then(response => {
            console.log("Registro Paciente exitosamente");
            this.fullscreenLoading = false;
            this.$router.push('/patient');
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
            if(!this.fillCreatePatient.run) {
                this.mensajeError.push("Run campo obligatorio")
            }
            if(!this.fillCreatePatient.dv) {
                this.mensajeError.push("Digito Verificador es un campo obligatorio")
            }
            if(!this.fillCreatePatient.name) {
                this.mensajeError.push("Nombre es un campo obligatorio")
            }
            if(!this.fillCreatePatient.fathers_family) {
                this.mensajeError.push("Apellido Paterno es un campo obligatorio")
            }
            if(!this.fillCreatePatient.mothers_family) {
                this.mensajeError.push("Apellido Materno es un campo obligatorio")
            }
            if(!this.fillCreatePatient.gender) {
                this.mensajeError.push("El Genero es un campo obligatorio")
            }
            if(!this.fillCreatePatient.birthday) {
                this.mensajeError.push("Fecha de Nacimiento es un campo obligatorio")
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
