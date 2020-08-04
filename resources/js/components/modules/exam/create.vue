<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Emitir orden de exámen</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/exam'">
              <i class="fas fa-arrow-left"></i> Regresar
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Registrar Orden</h3>
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
                          <small class="form-text text-muted">Utilizar: 12213213-1</small>
                         
                      </fieldset>
                      <fieldset class="form-group col-1">
                        <label>.</label>
                         <button class="form-control btn btn-info btn-sm" @click.prevent="getListPatients" >Buscar</button>
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
                              placeholder="Seleccione"
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
                        <label>Telefóno</label>
                          <input type="text" class="form-control" v-model="fillCreatePatient.telephone" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                       <fieldset class="form-group col-4">
                          <label>Sector</label>
                           <el-select v-model="fillCreatePatient.listSector" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listSector"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                      </fieldset>
                  </div>

                  <div class="form-row">
                       <fieldset class="form-group col-4">
                          <label>Fecha Nacimiento</label>
                           <input type="text"  class="form-control" v-model="fillCreatePatient.birthday" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                       <fieldset class="form-group col-2">
                          <label>Edad</label>
                           <input type="text" class="form-control" v-model="fillCreatePatient.name" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                  </div>
                  <hr>
                  <div class="form-row">
                       <fieldset class="form-group col-4">
                          <label>Fecha Solicitud</label>
                           <input type="text" class="form-control" v-model="fillCreatePatient.date_exam_order" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                       <fieldset class="form-group col-4">
                          <label>Fecha Toma Exámen</label>
                           <input type="text" class="form-control" v-model="fillCreatePatient.date_exam" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                       <fieldset class="form-group col-4">
                          <label>Fecha de Recepción</label>
                           <input type="text" class="form-control" v-model="fillCreatePatient.date_exam_reception" @keyup.enter="setRegistrarUsuario">
                      </fieldset>
                  </div>
                  <hr>
                  <div class="form-row">
                       <fieldset class="form-group col-6">
                          <label>Motivo Derivación</label>
                           <el-select v-model="fillCreatePatient.listDerivation" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listDerivation"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                      </fieldset>
                      <fieldset class="form-group col-6">
                          <label>BIRADS</label>
                           <el-select v-model="fillCreatePatient.listBIRADS" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listBIRADS"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                      </fieldset>
                  </div>
                  <div class="form-group">
                        <label>Observaciones</label>
                        <textarea class="form-control" rows="3" placeholder="Redactar ..."></textarea>
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
              run: '',
              name: '',
              fathers_family: '',
              mothers_family: '',
              address: '',
              birthday: '',
              gender: '',
              telephone: '',
              exams: ''
            },
            listGender: [
              {value: 'female', label: 'Femenino'},
              {value: 'male', label: 'Masculino'},
              {value: 'other', label: 'Otro'},
              {value: 'unknown', label: 'Prefiero no decir'}
            ],
            listSector: [
              {value: 'CELESTE', label: 'CELESTE'},
              {value: 'AMARILLO', label: 'AMARILLO'},
              {value: 'AZUL', label: 'AZUL'},
              {value: 'NARANJO', label: 'NARANJO'},
              {value: 'VERDE', label: 'VERDE'},
              {value: 'LARAMA', label: 'LARAMA'},
              {value: 'TORTUGA', label: 'TORTUGA'},
              {value: 'ARUMI', label: 'ARUMI'},
              {value: 'AÑAZCO', label: 'AÑAZCO'},
              {value: 'BORO', label: 'BORO'}
            ],
            listDerivation: [
              {value: 'mastalgia', label: 'MASTALGIA'},
              {value: 'quisteMamaIzquierda', label: 'QUISTE MAMA IZQUIERDA'},
              {value: 'screening', label: 'SCREENING'},
              {value: 'noduloBilateral', label: 'NODULO BILATERAL'}
            ],
            listBIRADS: [
              {value: 'I', label: 'I'},
              {value: 'II', label: 'II'},
              {value: 'III', label: 'III'},
              {value: 'IV', label: 'IV'},
              {value: 'V', label: 'V'},
              {value: 'VI', label: 'VI'},
              {value: 'NSP', label: 'NSP'},
              {value: '0', label: '0'}
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
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        getFile(e) {
            this.fillCreatePatient.oFotografia = e.target.files[0];       
        },
        getListPatients(){
          var url = '/administracion/patient/getPatient'
          console.log("id "+this.fillCreatePatient.run,);
          axios.get(url, {
            params: {
              'idPatient' : this.fillCreatePatient.run,
            }
          }).then(response => {
            console.log(response.data);
            this.fillCreatePatient.name = response.data.name;
            this.fillCreatePatient.run = response.data.run;
            this.fillCreatePatient.fathers_family = response.data.fathers_family;
            this.fillCreatePatient.mothers_family = response.data.mothers_family;
        
            this.fillCreatePatient.address = response.data.address;
            this.fillCreatePatient.birthday = response.data.birthday;
            this.fillCreatePatient.gender = response.data.gender;
            this.fillCreatePatient.exams = response.data.exams;

            this.fillCreatePatient.telephone = response.data.telephone;

            this.fullscreenLoading = false;
          })
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

          }).then(response => {
            console.log("Registro Paciente exitosamente");
            this.fullscreenLoading = false;
            this.$router.push('/patient');
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
