<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Exámen</h1>
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
                          <label>Servicio de Salud</label>
                           <el-select v-model="fillEditExam.servicioSalud" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listServicioSalud"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                      </fieldset>

                      <fieldset class="form-group col-4">
                          <label>Comuna</label>
                          <el-select v-model="fillEditExam.commune" filterable
                            placeholder="Seleccione"
                            clearable>
                              <el-option
                                v-for="item in listCommunes"
                                :key="item.id"
                                :label="item.code_deis+' - '+item.name"
                                :value="item.code_deis">
                              </el-option>
                          </el-select>
                      </fieldset>

                  </div>
                  <hr>
                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Establecimiento solicita Exámen</label>
                           <el-select v-model="fillEditExam.establishmentRequest" filterable
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listEstablishments"
                                  :key="item.id"
                                  :label="item.new_code_deis+' - '+item.alias"
                                  :value="item.new_code_deis">
                                </el-option>
                           </el-select>
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Profesional solicita Exámen</label>
                            <input type="text" class="form-control" v-model="fillEditExam.professional" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Fecha Solicitud</label>
                          <el-date-picker
                            v-model="fillEditExam.date_exam_order"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd">
                          </el-date-picker>
                          <small class="form-text text-muted"></small>
                      </fieldset>
                  </div>
                  <hr>
                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Establecimiento donde toma Exámen</label>
                           <el-select v-model="fillEditExam.establishmentExam" filterable
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listEstablishments"
                                  :key="item.id"
                                  :label="item.new_code_deis+' - '+item.alias"
                                  :value="item.new_code_deis">
                                </el-option>
                           </el-select>
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Médico</label>
                            <input type="text" class="form-control" v-model="fillEditExam.doctor" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Fecha Toma Exámen</label>
                          <el-date-picker
                            v-model="fillEditExam.date_exam"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd">
                          </el-date-picker>
                      </fieldset>
                  </div>
                  <hr>
                  <div class="form-row">
                       <fieldset class="form-group col-6">
                          <label>Motivo Derivación</label>
                          <input type="text" class="form-control" v-model="fillEditExam.derivation" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-3">
                          <label>BIRADS - Exámen Mamario</label>
                           <el-select v-model="fillEditExam.listBIRADSMam" 
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
                      <fieldset class="form-group col-3">
                          <label>BIRADS - Exámen EcoMamario</label>
                           <el-select v-model="fillEditExam.listBIRADSEcoMam" 
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
                  <hr>
                  <div class="form-row">
                       <fieldset class="form-group col-4">
                          <label>Fecha de Recepción</label>
                           <el-date-picker
                            v-model="fillEditExam.date_exam_reception"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd">
                          </el-date-picker>
                      </fieldset>
                  </div>
                  
                  <div class="form-group">
                        <label>Observaciones</label>
                        <textarea v-model="fillEditExam.diagnostic" class="form-control" rows="3" placeholder="Redactar ..."></textarea>
                      </div>


                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="setEditExam" 
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
            fillEditExam: {
               idExam: this.$attrs.id,
               run : '',
               dv  : '',
               name  : '',
               fathers_family : '',
               mothers_family  : '',
               gender  : '',
               birthday  : '',
               telephone  : '',
               address  : '',
               servicioSalud: '',
              establishmentRequest: '',
              professional: '',
              date_exam_order: '',
              establishmentExam: '',
              doctor: '',
              date_exam: '',
              derivation: '',
              listBIRADSMam: '',
              listBIRADSEcoMam: '',
              date_exam_reception: '',
              diagnostic: '',
              exams: '',
              commune: ''
            },

            listCommunes: [],
            listEstablishments: [],
            listGender: [
              {value: 'female', label: 'Femenino'},
              {value: 'male', label: 'Masculino'},
              {value: 'other', label: 'Otro'},
              {value: 'unknown', label: 'Prefiero no decir'}
            ],
            listServicioSalud: [
              {value: 'IQUIQUE', label: 'IQUIQUE'}
            ],
            listBIRADS: [
              {value: '0', label: '0'},
              {value: '1', label: 'I'},
              {value: '2', label: 'II'},
              {value: '3', label: 'III'},
              {value: '4', label: 'IV'},
              {value: '5', label: 'V'},
              {value: '6', label: 'VI'},
              {value: 'NSP', label: 'NSP'}
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
        this.getListEstablishments();
        this.getListCommunes();
      },
      methods: {
        getListEstablishments() {
          var route = '/administracion/establishments/getListEstablishments'
          axios.get(route).then( response => {
            this.listEstablishments = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
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
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getPatientById() {
          //this.fullscreenLoading = true;  
          var url = '/exam/getExamById'
          axios.get(url, {
            params: {
              'idExam' : this.fillEditExam.idExam,
            }
          }).then(response => {
            this.fillEditExam.servicioSalud        = response.data[0].servicio_salud;
            this.fillEditExam.commune              = (response.data[0].comuna)? response.data[0].comuna : ''; 
            this.fillEditExam.establishmentRequest = response.data[0].cesfam;
            this.fillEditExam.professional         = response.data[0].profesional_solicita;
            this.fillEditExam.date_exam_order      = response.data[0].date_exam_order;
            this.fillEditExam.establishmentExam    = (response.data[0].establecimiento_realiza_examen)? response.data[0].establecimiento_realiza_examen : ''; 
            this.fillEditExam.doctor               = response.data[0].medico;
            this.fillEditExam.date_exam            = response.data[0].date_exam;
            this.fillEditExam.derivation           = response.data[0].derivation_reason;
            this.fillEditExam.listBIRADSMam        = response.data[0].birards_mamografia;
            this.fillEditExam.listBIRADSEcoMam     = response.data[0].birards_ecografia;
            this.fillEditExam.date_exam_reception  = response.data[0].date_exam_reception;
            this.fillEditExam.diagnostic           = response.data[0].diagnostico;

            this.fullscreenLoading = false; 
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        setEditExam(){
            
            this.fullscreenLoading = true;

          var  url = '/exam/setEditExam'
          axios.post(url, {
            'idExam'              : this.fillEditExam.idExam,
            'servicioSalud'       : this.fillEditExam.servicioSalud,
            'commune'             : this.fillEditExam.commune,
            'establishmentRequest': this.fillEditExam.establishmentRequest,
            'professional'        : this.fillEditExam.professional,
            'date_exam_order'     : this.fillEditExam.date_exam_order,
            'establishmentExam'   : this.fillEditExam.establishmentExam,
            'doctor'              : this.fillEditExam.doctor,
            'date_exam'           : this.fillEditExam.date_exam,
            'derivation'          : this.fillEditExam.derivation,
            'listBIRADSMam'       : this.fillEditExam.listBIRADSMam,
            'listBIRADSEcoMam'    : this.fillEditExam.listBIRADSEcoMam,
            'date_exam_reception' : this.fillEditExam.date_exam_reception,
            'diagnostic'          : this.fillEditExam.diagnostic,

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
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        validForm() {
            this.error = 0;
            this.mensajeError = [];

            if(!this.fillEditExam.run) {
                this.mensajeError.push("Run Nombre es un campo obligatorio")
            }
            if(!this.fillEditExam.dv) {
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
