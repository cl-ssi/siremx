<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Paciente</h1>
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
                <h3 class="card-title">Editar Usuario</h3>
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
                          <input type="text" class="form-control" v-model="fillEditPatient.run" @keyup.enter="setRegistrarUsuario">
                          <small class="form-text text-muted">Sin punto ni guión ni digito verificador: Ej. 11111111</small>
                      </fieldset>
                      <fieldset class="form-group col-1">
                        <label>DV</label>
                          <input type="text" class="form-control" v-model="fillEditPatient.dv" @keyup.enter="setRegistrarUsuario">
                          <small class="form-text text-muted">D.V. : Ej: 4</small>
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Nombre</label>
                           <input type="text" class="form-control" v-model="fillEditPatient.name" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Apellido Paterno</label>
                           <input type="text" class="form-control" v-model="fillEditPatient.fathers_family" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Apellido Materno</label>
                          <input type="text" class="form-control" v-model="fillEditPatient.mothers_family" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Genero</label>
                           <el-select v-model="fillEditPatient.gender" 
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
                            v-model="fillEditPatient.birthday"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd"
                            default-value="1990-01-02">
                          </el-date-picker>
                          <small class="form-text text-muted"></small>
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Telefóno</label>
                          <input type="text" class="form-control" v-model="fillEditPatient.telephone" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col-8">
                          <label>Dirección</label>
                           <input type="text" class="form-control" v-model="fillEditPatient.address" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                  </div>


                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="setEditPatient" 
                    v-loading.fullscreen.lock="fullscreenLoading">Editar</button>
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
            fillEditPatient: {
               idPatient: this.$attrs.id,
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
      mounted(){
        this.getPatientById();
      },
      methods: {
        getPatientById() {
          this.fullscreenLoading = true;  
          var url = '/administracion/patient/getPatientById'
          axios.get(url, {
            params: {
              'idPatient' : this.fillEditPatient.idPatient,
            }
          }).then(response => {
            this.fillEditPatient.run              = response.data[0].run;
            this.fillEditPatient.dv               = response.data[0].dv;
            this.fillEditPatient.name             = response.data[0].name;
            this.fillEditPatient.fathers_family   = response.data[0].fathers_family;
            this.fillEditPatient.mothers_family   = response.data[0].mothers_family;
            this.fillEditPatient.gender           = (response.data[0].gender)? response.data[0].gender : ''; 
            this.fillEditPatient.birthday         = response.data[0].birthday;
            this.fillEditPatient.telephone        = response.data[0].telephone;
            this.fillEditPatient.address          = response.data[0].address;

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
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        setEditPatient(){
            if(this.validForm()) {
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading = true;

          var  url = '/administracion/patient/setEditPatient'
          axios.post(url, {
            'idPatient'      : this.fillEditPatient.idPatient,
            'run'            : this.fillEditPatient.run,
            'dv'             : this.fillEditPatient.dv,
            'name'           : this.fillEditPatient.name,
            'fathers_family' : this.fillEditPatient.fathers_family,
            'mothers_family' : this.fillEditPatient.mothers_family,
            'gender'         : this.fillEditPatient.gender,
            'birthday'       : this.fillEditPatient.birthday,
            'telephone'      : this.fillEditPatient.telephone,
            'address'        : this.fillEditPatient.address,

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
        validForm() {
            this.error = 0;
            this.mensajeError = [];

            if(!this.fillEditPatient.run) {
                this.mensajeError.push("Run Nombre es un campo obligatorio")
            }
            if(!this.fillEditPatient.dv) {
                this.mensajeError.push("Digito Verificador es un campo obligatorio")
            }
        
            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        }
      }
    }
</script>
